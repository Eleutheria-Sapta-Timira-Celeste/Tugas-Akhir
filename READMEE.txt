Studi Kasus => Website Sekolah

Frontend	: Html dan CSS
Backend		: PHP, JavaScript
Text Editor	: Notepad, Visual Studio Code
Web Server	: Xampp
Framework	: Boostrap

Pengguna	: 1 User
		 	  2 Admin


Struktur database
-------------------------------------------

# Database => db_sekolah

#Struktur Tabel Pendaftaran
==============================================================
id 		|int(11) NOT NULL,
full_name 		|varchar(50) 	NOT NULL,
address 		|varchar(80) 	NOT NULL,
gender 			|varchar(50) 	NOT NULL,
dob 			|varchar(50) 	NOT NULL,
father_name 	|varchar(50) 	NOT NULL,
mother_name 	|varchar(50) 	NOT NULL,
admit_to 		|varchar(100) 	NOT NULL,
previous_school |varchar(50) 	DEFAULT NULL,
email 			|varchar(30) 	DEFAULT NULL,
phone 			|varchar(30) 	NOT NULL,
intro 			|varchar(500) 	NOT NULL,
registered_on 	|varchar(30) 	NOT NULL,
image_url 		|varchar(100) 	DEFAULT NULL


#Struktur Tabel Feedback
==============================================================
id 					|int(11) 		NOT NULL,
date` 				|varchar(50) 	NOT NULL,
time` 				|varchar(30) 	NOT NULL,
name` 				|varchar(20) 	NOT NULL,
email` 				|varchar(30) 	NOT NULL,
message` 			|varchar(999) 	NOT NULL

#Struktur Tabel Pengumuman
==============================================================
id 					|int(11) 		NOT NULL,
title 				|varchar(500) 	NOT NULL,
image_url 			|varchar(500) 	NOT NULL,
message 			|varchar(500) 	NOT NULL,
trun_flash 			|varchar(2) 	NOT NULL

#Struktur Tabel Galeri Album
==============================================================
id 					|int(11) 		NOT NULL,
album_name 			|varchar(30) 	NOT NULL

#Struktur Tabel Galeri Images
==============================================================
id 					|int(11) 		NOT NULL,
album 				|varchar(500) 	NOT NULL,
image_url 			|varchar(500) 	NOT NULL

#Struktur Tabel Management Committe
==============================================================
id 					|int(11) 		NOT NULL,
name 				|varchar(30) 	NOT NULL,
position 			|varchar(50) 	NOT NULL,
contact_no 			|varchar(20) 	NOT NULL,
image_src 			|varchar(200) 	NOT NULL

#Struktur Tabel Manipulators/admin
==============================================================
id 					|int(11) 		NOT NULL,
name 				|varchar(50) 	NOT NULL,
identity_code 		|varchar(30) 	NOT NULL,
password 			|varchar(30) 	NOT NULL,
image 				|varchar(500) 	NOT NULL,
last_update 		|varchar(50) 	DEFAULT NULL

#Struktur Tabel Notification
==============================================================
id 					|int(11) 		NOT NULL,
page 				|varchar(30) 	NOT NULL,
site 				|varchar(20) 	NOT NULL,
total_notification 	|int(11) 		NOT NULL DEFAULT 0

#Struktur Tabel School Routine
==============================================================
id 					|int(11) 		NOT NULL,
class 				|varchar(1000) 	DEFAULT NULL,
routine_url 		|varchar(1000) 	DEFAULT NULL,
last_modified 		|varchar(100) 	DEFAULT NULL

#Struktur Tabel School Notice
==============================================================
id 					|int(11) 		NOT NULL,
logo 				|varchar(999) 	NOT NULL,
posted_by 			|varchar(50) 	NOT NULL,
image_url 			|varchar(999) 	NOT NULL,
about 				|varchar(500) 	NOT NULL,
notice_description 	|varchar(9999) 	NOT NULL,
date 				|varchar(30) 	NOT NULL,
time 				|varchar(30) 	NOT NULL,
total_views 		|int(10) 		NOT NULL,
total_downloads 	|int(10) 		NOT NULL,
last_modified 		|varchar(50) 	NOT NULL

#Struktur Tabel Staff
==============================================================
id 					|int(11) 		NOT NULL,
name 				|varchar(100) 	NOT NULL,
post 				|varchar(100) 	NOT NULL,
qualification 		|varchar(100) 	NOT NULL,
contact 			|varchar(100) 	NOT NULL,
image_src 			|varchar(100) 	NOT NULL

#Struktur Tabel Web Content
==============================================================
id 					|int(11) 		NOT NULL,
content_about 		|varchar(500) 	NOT NULL,
one 				|varchar(1000) 	NOT NULL,
two 				|varchar(1000) 	NOT NULL,
three 				|varchar(1000) 	NOT NULL,
four 				|varchar(1000) 	NOT NULL,
five 				|varchar(1000) 	NOT NULL,
six					|varchar(1000) 	NOT NULL,
seven 				|varchar(1000) 	NOT NULL,
eight 				|varchar(1000) 	NOT NULL,
nine 				|varchar(500) 	NOT NULL,
ten 				|varchar(500) 	NOT NULL,
eleven 				|varchar(500) 	NOT NULL,
twelve 				|varchar(500) 	NOT NULL,
thirteen 			|varchar(500) 	NOT NULL,
fourteen 			|varchar(500) 	NOT NULL,
fifteen 			|varchar(1000) 	NOT NULL,
sixteen 			|varchar(1000) 	NOT NULL,
seventeen 			|varchar(500) 	NOT NULL,
eighteen 			|varchar(500) 	NOT NULL,
ninteen 			|varchar(500) 	NOT NULL,
twenty 				|varchar(500) 	NOT NULL,
twentyone 			|varchar(500) 	NOT NULL

























