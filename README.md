sozdaem bazu dannix

# podklyuchim bazu dannix v proekt
    -sozdaem fayl .env v korne proekta
    -kopiruem soderjimoe fayla .env.example v fayl .env
    -redaktiruem parametri podklyuchenie bazu dannix

# ustanovit zavisimosti
composer install

# zapustit migracii i zapolnenie bazu s pervichnimi dannimi
php artisan migrate --seed

# generaciya klyucha
php artisan key:generate

# zapusk proekta
php artisan serve

[//]: # (posle kajdogo deploya)
dlya universiteta:
    1. php artisan db:seed --class=RegionSeeder
    2. php artisan db:seed --class=InitSeeder

dlya ostalnix
1. /json2db - **zagrujaet vse universiteti s regionami**
2. /done - **ispravit regioni**
3. php artisan db:seed --class=AdminSeeder - **dobavit moderatora TATU(Fergana)**
4. php artisan db:seed --class=UniversitySeeder - **dobavit fakulteti i napravleniya TATU(Fergana)**
5. importirovat studenti s faylov /init_data/students/*
6. php artisan db:seed --class=CertificateLanguageSeeder
7. php artisan db:seed --class=CertificatePointSeeder

# dorabotki
1. admin userlarning parolini reset qilish funkciyasi