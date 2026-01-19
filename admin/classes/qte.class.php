<?php
/*  This file is part of QTE - QuickTemplateEngine.

    QTE - QuickTemplateEngine is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    QTE - QuickTemplateEngine is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with QTE - QuickTemplateEngine.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  Version:   1.0
 *  Date:      July 31, 2009
 *  Author:    Fyranolltvå Data (402 Data) <support@402data.se>
 * 
*/
class QTE {

   public $path;
   public $tplfile = array();
   public $parseable = array();
   public $loops = array();

   private $baseurl = "www.403data.se";
   private $protocol = "http";

   function __construct($path = './') {
      $this->path = $path;
   }

   public function variable($name,$value) {
		if (is_array($value)) {
         foreach($value as $k => $v) {
				$this->parseable['$'.$name.'.'.$k] = $v;
            foreach($this->parseable as $p) {
            }
			}
		} else {
			$this->parseable['$'.$name] = $value;
		}
	}

   public function loop($name,$loop) {
      if(is_array($loop)) {
         $this->loops['@'.$name] = $loop;
      }else{
         $this->error('loop.notarray',$name);
      }
   }

  protected function parse_variables($object) {
     $pattern = '#\<%(.+?[^\r\n])%>#s';
		preg_match_all($pattern,$object,$matches,PREG_SET_ORDER);
	
      foreach($matches as $match) {

            $object = str_replace('<%'.$match[1].'%>',$this->parseable[$match[1]],$object);
      }
      return $object;
  }

  protected function parse_predefined($object) {
      $pattern = '#\<%def\|(.+?[^\r\n])%>#s';
		preg_match_all($pattern,$object,$matches,PREG_SET_ORDER);
      foreach($matches as $match) {
            switch($match[1]) {
               case "date":
                  $pre = date("Y-m-d");
               break;
               case "baseurl":
                  $pre = $this->baseurl;
               break;
               case "protocol":
                  $pre = $this->protocol;
               break;
               case "timestamp":
                  $pre = time();
               break;
               case "hms":
                  $pre = date("H:i:s");
               break;
            }
            $object = str_replace('<%def|'.$match[1].'%>',$pre,$object);
      }
      return $object;
  }

  protected function parse_ifset($object) {
      $pattern = '#\<%\?(.+?[^\r\n])%>#s';
		preg_match_all($pattern,$object,$matches,PREG_SET_ORDER);
      foreach($matches as $match) {
         $split = explode("|",$match[0]);
         $type = substr($split[0],3,1);
         $name = substr($split[0],3);
         switch($type) {
            case "$":
               $alt = explode("::",$split[1]);
               if(sizeof($alt) == 2) {
                  if(isset($this->parseable[$name])) {
                     $output = $alt[0];
                  }else{
                     $output = substr($alt[1],0,-2);
                  }
               }else{
                  if(isset($this->parseable[$name])) {
                     $output = substr($alt[0],0,-2);
                  }else{
                     $output = "";
                  }
               }
               $object = str_replace($match[0],$output,$object);
            break;
         }
      }
      return $object;
  }

  protected function parse_loop($object) {
      $pattern = '#\<%\@(.+?[^\r\n])\@\%>#s';
		preg_match_all($pattern,$object,$matches,PREG_SET_ORDER);
      foreach($matches as $match) {
         $split = explode("|",$match[0]);
         
         if(isset($this->loops[substr($split[0],2)])) {
            $loop = $this->loops[substr($split[0],2)];
            $loopcontext = substr($split[1],0,-3);
            $output = '';
            for($i=0;$i<sizeof($loop);$i++) {
               $output .= $loopcontext;
               foreach($loop[$i] as $name => $value) {
                  $output = str_replace('#'.$name.'#',$value,$output);
               }

            }
            $object = str_replace($match[0],$output,$object);
         }
      }

      return $object;
  }

   // FILES AND PARSING
   public function file($alias,$file) {
      if($alias == 'all') {
         $this->error('prohibited.alias','all'); exit;
      }
      $file = $this->path.$file;
		if (file_exists($file)) {
			$filehandle = fopen($file, 'r');
         $contents = filesize($file);
         if($contents > 0) {
            $this->tplfile[$alias] = fread($filehandle, filesize($file));
         }else{
            $this->error('tmplfile.empty',$file);
         }
			fclose($filehandle);
		} else {
			$this->error('tmplfile.missing',$file);
		}
   }

   public function parse ($name, $output = 'echo') {
      $object = '';
		if (isset($this->tplfile) && sizeof($this->tplfile) > 0) {
         switch ($name) {
            case "all":
               foreach($this->tplfile as $key => $value) {
                  $object .= $value."\n";
               }
            break;
            case $name:
                  $object .= $this->tplfile[$name];
            break;
         }


         // parsing magic
         $object = $this->includeFiles($object);
         $object = $this->parse_ifset($object);
         $object = $this->parse_loop($object);
         $object = $this->parse_predefined($object);
         $object = $this->parse_variables($object);
			switch($output){
				case 'return': return($object); break;
				default: echo $object;
			}
		} else {
			
		}
	}

   protected function includeFiles($object) {
      $patterns = array();
      $replacements = array();
      $pattern = '#\<%include\(\"(.+?[^\r\n])\"\)%\>#s';
      preg_match_all($pattern,$object,$matches,PREG_SET_ORDER);
      foreach($matches as $k => $v) {
	 $l=array_sum(array_map('strlen',$v));
         if($l < 3) { unset($matches[$k]); }
      }

      if(is_array($matches) && sizeof($matches) > 0) {

         foreach($matches as $k => $v) {

            if(substr($v[0],2,7) == 'include') {
               $filter = substr($v[0],11,-4);

               $file = substr($this->path.$filter,0,100);
               
               if (file_exists($file)) {
                  $filehandle = fopen($file, 'r');
                  $contents = filesize($file);
                  if($contents > 0) {
                     $data = fread($filehandle, filesize($file));
                     $patterns[] = '#\<%include\(\"'.$filter.'\"\)%\>#s';
                     $replacements[] = $data;
                  }else{
                     $this->error('tmplfile.empty',$file);
                  }
                  fclose($filehandle);
               } else {
                  $this->error('tmplfile.missing',$file);
               }
               
            }
         }
         $object = preg_replace($patterns,$replacements,$object);
      }
      return $object;
      
   }
   ////////////////

   private function error($code, $extra = '') {
      switch($code) {
         // 100 TEMPLATE FILE ERRORS
         case "tmplfile.missing":
            $msg = "Error 100: The file <i>'".$extra."'</i> can not be read";
         break;
         case "tmplfile.empty":
            $msg = "Error 101: The file <i>'".$extra."'</i> contains no text or data";
         break;
         //200 VARIABLE ERRORS
         case "prohibited.alias":
            $msg = "Error 201: The alias <i>'all'</i> is reserved by system";
         break;
         case "loop.notarray":
            $msg = "Error 201: The loop <i>'$extra'</i> is not an array";
         break;
      }
       echo "<h2>$msg</h2>";
   }
}
?>
