1. Remove "installed" file
2. Move _lst_enquesta.php into the admin and rename to lst_enquest.php
3. Add an entry for lst_enquesta ademin menu "menu.php"
3. Change "certificat" link for enquesta form:

<a href="certificat.php?id=<?=$id?>" target="_blank"><img style="vertical-align:middle" src="images/pdf.jpg"/></a>

to 

<a href="../enquesta/enquesta_form.php?id=<?=$id?>" target="_blank"><img style="vertical-align:middle" src="images/pdf.jpg"/></a>