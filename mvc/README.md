# MVC - Blog System

CMS mit User Login, Image Upload, Kategorien, Kommentare, Sterne-Ratings, Blog Posts, Medien Bibliothek, ...

## Build Pipeline

Im Wurzelverzeichnis des MVC befindet sich ein `package.json` File. Dieses File beinhaltet NPM Scripts, mit denen sowohl
SASS Files transpiliert werden können, als auch JavaScript Files aus dem Resources Ordner in den Public Ordner
kopiert werden.
Um alle benötigten Abhängigkeiten (SASS & UglifyJS) zu installieren, muss `npm install` ausgeführt werden. Für einen vollständigen
Build kann `npm run build` verwendet werden.

## Ordner

Die Ordnerstruktur ist zwar nicht Teil des MVC, wird aber vom MVC vorgegeben.

+ `/app` wird alle Dateien beinhalten, die die Logik der Anwendung beinhalten. Diese Dateien werden die Files in `/core` verwenden.
+ `/config` wird alle Konfigurations-Dateien beinhalten. Diese sollten wirklich nur die Werte beinhalten und keinerlei Logik.
+ `/core` beinhaltet die Funktionalitäten, die im MVC enthalten sind und für vermutlich in den meisten Anwendung benötigt werden. Die Dateien in `/app` machen sich diese zunutze und bauen eine Anwendung daraus. Ein MVC Framework ist dazu gedacht, dass Logik, die in sehr vielen Anwendungen benötigt wird (bspw. Login Funktionalitäten, Datenbankverbindung, Session Management, etc.) einmal implementiert werden und dann in einer Anwendung, die auf das MVC aufsetzt, verwendet werden können.
+ `/public` stellt den Webroot der mit dem MVC gebauten Anwendung dar. Hier findet sich eine einzige `index.php` Datei, die die Anwendung und das MVC startet. Außerdem müssen hier alle Dateien sich befinden, die über den Browser abgerufen werden sollen (bspw. Bilder, CSS und JS Dateien). Daher ist auch der `/storage` Ordner hier herein verlinkt, weil Uploads in den Storage Ordner kommen werden, diese werden aber häufig über den Browser erreichbar sein müssen (bspw. macht es keinen Sinn ein Avatar Bild hochzuladen, dass über den Browser nicht geladen werden kann.).
+ `/resources` beinhaltet die rohen JS Dateien (bspw. Vue, React, ...), CSS Files, die erst transpiliert werden müssen (bspw. Sass, Less, Scss, ...) und die Views.
+ `/resources/views` beinhaltet das HTML, das zur Anzeige der in den Controllern berechneten Daten benötigt wird. Hier wird also die Programmlogik (Controller) komplett von der Anzeige (Views) getrennt. PHP und HTML werden nur in den Views gemischt - und hier auch nur sehr sparsam.
    + `/resources/views/layouts`: Layouts sind die größten Einheiten der Views und stellen sowas dar wie HTML Grundmarkup für Desktop Ansicht, Mobile Ansicht, Ansicht auf E-Readern etc. - durch MediaQueries ist das nicht mehr so wichtig, kann aber immernoch verwendet werden, wenn eine Seite komplett neu gebrandert werden soll, oder um ein neues Layout an einer kleinen Anzahl von User*innen zu testen.
    + `/resources/views/templates` beinhaltet die nächstkleinere Einheit. Ein Template ist dabei etwas wie "Content + Sidebar", "nur Content" oder "3-spaltiger Content" - ein Template bezieht sich also auf den Content Bereich, während ein Layout sich auf die gesamte Seite bezieht.
    + `/resources/views/partials` sind die kleinsten Bausteine der Views. Sie dienen dazu, dass einzelne HTML Blöcke, die wiederverwendet werden können, in einer einheitlichen Form gespeichert werden können. Solche Blöcke könnten beispielsweise "Post Teaser", "Navbar", "Image Slider" sein - also Bausteine, die in unterschiedlichen Templates Verwendung finden können.
+ `/routes` beinhaltet das Mapping von in die Adresszeile des Browsers eingegebenen URLs auf Controller und Actions. Actions sind hierbei die Methoden der Controller. Wir unterscheiden zwischen Web-Routen und API-Routen. Zweitere können verwendet werden, wenn eine API (bswp. JSON), implementiert werden soll.
+ `/storage` beinhaltet alle Arbeitsdateien. Also beispielsweise Uploads, generierte Dateien, Cache, Logs, etc. - das ist also der Ordner, in den das MVC Dateien speichern kann, die dann irgendwann anders verwendet werden.

## Models / Datenbanktabellen

+ User - users
  + id* INT A_I PK
  + username* VARCHAR(255) UK
  + email* VARCHAR(255) UK
  + password* (Hash) VARCHAR(255)
  + is_admin BOOL NULL default:0
  + created_at* (Creation Date) TIMESTAMP
  + updated_at* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL
- Room - rooms
  + id* INT A_I PK
  + name* VARCHAR(255)
  + location TEXT
  + room_nr* VARCHAR(10)
  + created_at* (Creation Date) TIMESTAMP
  + updated_at* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL
- Room Features - room_features (Raumausstattung für Filterung)
  + id* INT A_I PK
  + name* VARCHAR(255)
  + description TEXT
  + created_at* (Creation Date) TIMESTAMP
  + updated_at* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL
- rooms_room_features_mm
  + id* INT A_I PK
  + room_id* INT
  + room_feature_id* INT
- Equipment - equipments
  + id* INT A_I PK
  + name* VARCHAR(255)
  + description TEXT
  + units* INT
  + type_id* INT
  + created_at* (Creation Date) TIMESTAMP
  + updated_at* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL
- Types - types
  + id* INT A_I PK
  + name* VARCHAR(255)
  + created_at* (Creation Date) TIMESTAMP
  + updated_at* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL
- Booking - bookings
  + id* INT A_I PK
  + user_id* INT
  + time_from* TIMESTAMP
  + time_to* TIMESTAMP
  + foreign_table* VARCHAR(255) // rooms, equipments
  + foreign_id* INT
  + created_at* (Creation Date) TIMESTAMP
  + updated_at* (Zeitpunkt des letzten Updates) TIMESTAMP ou_CT
  + deleted_at TIMESTAMP NULL

## Controllers

C Create
R Read/List
U Update
D Delete

+ UserController: CRUD
+ FileController: CRUD
+ PostController: CRUD
+ CategoryController: CRUD
+ CommentController: CR_D

## Core

+ Bootstrap
+ Router
+ Database
+ View
+ Config
+ Session
+ Validator
+ AbstractModel
+ AbstractUser
+ AbstractFile
+ SoftDelete Trait
+ ...

## Views / Seiten

+ Post Liste (Startseite)
+ Post Detail (Single Post)
+ Category Liste
    + Category Post Liste
+ Login
+ Sign-Up
+ Admin: Startseite
+ Admin: Category Liste
+ Admin: Category Edit
+ Admin: Category Create
+ Admin: User Liste
+ Admin: User Edit
+ Admin: User Create
+ Admin: Post Liste
+ Admin: Post Edit
+ Admin: Post Create
+ Admin: Files Liste (Medienbibliothek)
+ Admin: Files Edit
+ Admin: Files Upload
+ Admin: Comments Liste
