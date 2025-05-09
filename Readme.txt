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
===========================================
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
===========================================
id 				|int(11) 		NOT NULL,
date` 			|varchar(50) 	NOT NULL,
time` 			|varchar(30) 	NOT NULL,
name` 			|varchar(20) 	NOT NULL,
email` 			|varchar(30) 	NOT NULL,
message` 		|varchar(999) 	NOT NULL

























