<!-- omit in toc -->

# Szerveroldali webprogramozás 2022/23/2 - Laravel beadandó

<!-- omit in toc -->

## Tartalomjegyzék

-   [Szerveroldali webprogramozás 2022/23/2 - Laravel beadandó](#szerveroldali-webprogramozás-2022232---laravel-beadandó)
    -   [Tartalomjegyzék](#tartalomjegyzék)
    -   [Fontos tudnivalók](#fontos-tudnivalók)
    -   [Feladat](#feladat)
        -   [Adatmodellek](#adatmodellek)
        -   [Kapcsolatok](#kapcsolatok)
    -   [Értékelés](#értékelés)
        -   [Minimumkövetelmények](#minimumkövetelmények)
        -   [Funkcionális követelmények és pontozásuk](#funkcionális-követelmények-és-pontozásuk)
    -   [Hasznos hivatkozások](#hasznos-hivatkozások)

## Fontos tudnivalók

Amennyiben az alábbiak közül **bármelyik** nem teljesül a beadott munkára, a beadandó feladat **elutasított**, tehát átmenő gyakorlati érdemjegy nem kapható!

-   Az elkészült projektet **HATÁRIDŐRE** (2023. április 30. 23:59) a végleges állapotában fel kell tölteni a kurzus Canvas felületére! Késés alapvetően **NEM** megengedett; kivéve egyéni megegyezésre a gyakorlatvezető felé **időben jelzett, igazolható, méltányossági** alapon (pl. haláleset, tartós betegség). _(Az "el kellett utaznom", "zh-t írtam tegnap" és "nem működik a(z) gépem/internet" típusú megkereséseket mérlegelés nélkül el fogjuk utasítani, hiszen circa **1,5 hónap** állt rendelkezésre ezek áthidalására.)_
-   A csomagkezelők által karbantartott mappákat (`vendor` és `node_modules`) beküldeni **TILOS**!
-   A beadott feladatot a gyakorlatvezetővel egyeztetett időpontban szóban meg **KELL** védeni. A védés során a beadott munkával **MEGEGYEZŐ** verziót kell bemutatni, a beadás után tehát **TILOS** tovább dolgozni.
-   A beadandó feladat **EGYÉNI** munka, tehát bárminemű összedolgozás, másolás, csalás **TILOS**! A felsoroltak gyanúja esetén akár **MINDEN** érintett hallgató beadását véglegesen visszautasíthatjuk! Ez nem azt jelenti, hogy nem lehet dokumentációt használni vagy együtt ötletelni, de a kódon mindenki önállóan kell dolgozzon. **Emiatt különösen érdemes arra ügyelni, hogy időközben ne szivárogjon ki a munka például publikus git repoba, mert ilyen esetben nem fogunk nyomozásokat folytatni, hogy ki a forrás!**
-   A beadott munka tisztaságát tanúsító, itt olvasható szövegnek `STATEMENT.md` fájlnéven, a hallgató adataival egyértelműen kitöltve szerepelnie **KELL** a beadott állományban:

```
  # Nyilatkozat

  Én, <NÉV> (Neptun kód: <NEPTUN KÓD>) kijelentem, hogy ezt a megoldást én küldtem be a Szerveroldali webprogramozás tárgy Laravel beadandó feladatához.
  A feladat beadásával elismerem, hogy tudomásul vettem a nyilatkozatban foglaltakat.

  - Kijelentem, hogy ez a megoldás a saját munkám.
  - Kijelentem, hogy nem másoltam vagy használtam harmadik féltől származó megoldásokat.
  - Kijelentem, hogy nem továbbítottam megoldást hallgatótársaimnak, és nem is tettem azt közzé.
  - Tudomásul vettem, hogy az Eötvös Loránd Tudományegyetem Hallgatói Követelményrendszere (ELTE szervezeti és működési szabályzata, II. Kötet, 74/C. §) kimondja, hogy mindaddig, amíg egy hallgató egy másik hallgató munkáját - vagy legalábbis annak jelentős részét - saját munkájaként mutatja be, az fegyelmi vétségnek számít.
  - Tudomásul vettem, hogy a fegyelmi vétség legsúlyosabb következménye a hallgató elbocsátása az egyetemről.
```

## Feladat

A feladatod egy fikcionális labdarúgó-bajnokságot kezelő webes alkalmazás elkészítése, ahol böngészhetők és megfelelő jogosultság esetén szerkeszthetők az egyes csapatok és játékosok adatai, illetve a meccsek időpontjai és eseményei.

Szeretnénk, ha a feladatot alapvetően kellő **alkotói szabadsággal** fognátok meg, nem pedig kőbe vésett dologként. Lényegében minden (tiszta módon keletkezett) megoldás elfogadható, amíg az alább részletezett követelményeket teljesíti; tehát abban, ami nincs a továbbiakban specifikálva, **teljesen szabadon** mozoghattok. Érdemes jól tanulmányozni az elvárásokat, ugyanis **csak az ér pontot, amit expliciten leírtunk** a pontozásban; a kurzus teljesítése szempontjából tehát felesleges egy túlgondolt/bonyolultabb feladatot megoldani, persze mindig örülünk, ha extra szorgalmasak vagytok. :)

A feladathoz **kötelező kiinduló csomag nincs**, javasolt azonban a **Laravel Breeze** használata, amely a frontend beüzemelésen felül a hitelesítés alapját is biztosítja.

### Adatmodellek

-   `Team` - egy csapat
    -   `id`
    -   `name` (string, egyedi)
    -   `shortname` (string, egyedi, max. 4 karakter)
    -   `image` (string, lehet null)
    -   `időbélyegek`
-   `Player` - egy játékos adatai
    -   `id`
    -   `name` (string)
    -   `number` (integer, a játékos mezszáma)
    -   `birthdate` (date)
    -   `időbélyegek`
-   `Game` - egy mérkőzés
    -   `id`
    -   `start` (datetime)
    -   `finished` (logikai, alapértelmezetten hamis)
    -   `időbélyegek`
-   `Event` - egy esemény egy mérkőzésen belül
    -   `id`
    -   `type` (enum - eseménytípusok: gól, öngól, sárga lap, piros lap)
    -   `minute` (integer, hanyadik percben történt az esemény)
    -   `időbélyegek`
-   `User` - ez már készen érkezik, csak egy mezővel kell kiegészíteni
    -   `is_admin` (logikai, alapértelmezetten hamis)

### Kapcsolatok

-   `Team` 1 : N `Player`
-   `Team` 1 : N `Game` (pl. `home_team_id` néven - a hazai oldalon játszó csapat azonosítója)
-   `Team` 1 : N `Game` (pl. `away_team_id` néven - a vendég oldalon játszó csapat azonosítója)
-   `Game` 1 : N `Event`
-   `Player` 1 : N `Event`
-   `User` N : N `Team`

## Értékelés

### Minimumkövetelmények

Külön pontszám nélküli **minimumkövetelményként** teljesítendők az alábbi programozási feladatok:

-   Az alkalmazást **Laravel 10** keretrendszerben, **SQLite** adatbázis használatával kell megvalósítani!
-   A csomagkezelők által karbantartott mappákat (`vendor` és `node_modules`) feltölteni **TILOS**! Ugyanakkor alapelvárás, hogy a beadott _.zip_-ből az alkalmazás a következő inicializációs fájlokkal (és nem többel) **beüzemelhető** legyen:
    -   [init.bat](https://gist.githubusercontent.com/totadavid95/10c2b013a5c8a0a98d16cb21c45d217a/raw/b94112422523b68a159a0b96912f86fe46868ac3/init.bat) (Windows-on)
    -   [init.sh](https://gist.githubusercontent.com/totadavid95/10c2b013a5c8a0a98d16cb21c45d217a/raw/b94112422523b68a159a0b96912f86fe46868ac3/init.sh) (Linux-on / Mac-en)
-   Fontos az **igényesen kidolgozott felhasználói felület** (frontend). Ez nem azt jelenti, hogy mindent csicsázni kell, de pl. legyen egy közös elrendezése az oldalaknak, ahonnan minden funkcionalitás elérhető a felhasználók számára (nem kell útvonalakat kutatni a kódban és/vagy lekéréseket kézzel építgetni), az űrlapmezők legyenek egyértelműen felcímkézve, hiba esetén kapjanak megfelelő tájékoztatást a **pontos** hibáról, valamint a sikeres műveletekre is legyen valami visszajelzés. A frontend technológia is szabadon választható: javasolt a Tailwind CSS vagy Bootstrap.
-   Az **időzóna** legyen magyar időre állítva az alkalmazás konfigurációjában!
-   A felküldött adatokat **minden esetben** validálni kell **szerveroldalon**, a megfelelő ellenőrzés része az egyes műveletek megvalósítására kapható pontszámnak! HTML szintű validáció (pl. `required` attribútum) **ne is legyen** a kódban, mert ez abszolút nem véd az alkalmazásunkat kijátszani szándékozók ellen!

### Funkcionális követelmények és pontozásuk

-   **Modellek és seeder** (4 pont)
    -   Minden modellből kerüljön tárolásra észszerű mennyiségben (pl. 10-15 csapat), valamint a köztük lévő kapcsolatokból is generálj!
    -   A seeder fedjen le minél több esetet, tehát legyenek pl. már lejátszott, folyamatban lévő és jövőbeli meccsek is, valamint változatos események az egyes meccseken belül!
    -   Minden szükséges seedelés egyetlen parancs kiadására történjen meg: `php artisan db:seed` vagy `php artisan migrate:fresh --seed`
    -   Az egyszerű felhasználók **csak** `userX@szerveroldali.hu` (ahol X eleme természetes számok) e-mail címmel és `password` jelszóval jöjjenek létre az egyszerűség kedvéért!
    -   Egyetlen **admin** jogosultságú felhasználó legyen, akinek a bejelentkezési adatai fixen: `admin@szerveroldali.hu` - `adminpwd`
-   **Főoldal** (1 pont)
    -   Az alkalmazás gyökér útvonalán jelenjen meg egy statikus oldal, amelyen tájékoztatást kapunk arról, hogy milyen webhelyre érkeztünk, és a következő menüpontok közül választhatunk:
        -   mérkőzések
        -   csapatok
        -   tabella
        -   kedvenceim
-   **Mérkőzések oldal** (4 pont)
    -   Ezt az oldalt bárki (vendég, bejelentkezett, admin) megtekintheti.
    -   Az oldalon megjelenik az összes mérkőzés: a mérkőzésben részt vevő két csapat neve (vagy rövidítése), logója (ha van feltöltve, különben placeholder kép) és a meccs kezdési időpontja.
    -   A mérkőzések alapvetően időrendi sorrendben jelennek meg, de külön szekcióba ki kell emelni az éppen folyamatban lévő meccseket (amelyek kezdési időpontja elmúlt, de nincsenek még befejezettként jelölve).
    -   A folyamatban lévő és befejezett mérkőzéseknél az aktuális eredmény is legyen látható! Ezt az adott meccshez tartozó gól és öngól típusú események alapján kell valós időben **kiszámolni**, tehát nem szabad külön fix adatként eltárolni az eredményt! (Figyelem: az öngólt értelemszerűen az ellenfél javára kell számolni, nem pedig a gólszerző játékos csapatának!)
    -   Lapozással biztosítsd, hogy csak bizonyos (pl. 10, 15, 20, stb.) számú mérkőzés jelenjen meg egyidejűleg az oldalon, utána lapozni kelljen! Ez alól kivételt képezhet a folyamatban lévő meccsek szekciója, amelyekről feltételezhetjük, hogy egyszerre viszonylag kevés van, és akár minden lapozott oldal tetején is szerepelhet.
    -   Egy adott mérkőzésre kattintva annak részletező oldalára jutunk.
-   **Mérkőzésrészletező oldal** (2 pont)
    -   Ezen az oldalon is láthatók a paraméterként kapott meccs alapvető adatai, illetve folyamatban lévő vagy befejezett mérkőzés esetén az eredmény is.
    -   Időrendi sorrendben megjelenik az adott meccshez tartozó összes esemény. (pl. "7. perc, Unikornis FC, gól, Programo Zoltán")
-   **Új esemény rögzítése** (3 pont)
    -   Az **admin** felhasználó számára a mérkőzésrészletező oldalról (pl. az alján elhelyezett űrlapon vagy innen elérhető külön oldalon) lehetőség van új esemény rögzítésére egy folyamatban lévő mérkőzéshez.
    -   Ehhez meg kell adnia a következőket: hányadik játékpercben (1 és 90 közötti egész), milyen típusú esemény (gól, öngól, sárga lap, piros lap) történt és ki az érintett játékos. Alapvetően nem szükséges külön kiválasztani (vagy tárolni) a csapatot, hiszen azt a játékos személye egyértelműen meghatározza.
    -   Az érintett játékost egy listából (pl. legördülő menü vagy rádiógombok) lehet kiválasztani, amely csapat és mezszám szerint rendezett.
-   **Esemény visszavonása** (1 pont)
    -   Az **admin** felhasználó az egyes eseményeket vissza is vonhatja (törölheti), pl. téves rögzítés esetén.
    -   Visszavonni csak addig lehet eseményeket, amíg a meccs folyamatban van. Lezárt mérkőzés eseményeihez nem lehet hozzányúlni.
-   **Meccs lezárása** (1 pont)
    -   Az **admin** felhasználó számára a mérkőzésrészletező oldalról lehetőség van a meccs lezárására, tehát befejezetté nyilvánítására.
    -   A lezárt meccshez további esemény nem rögzíthető, illetve a meccs ezután nem jelenik meg a folyamatban lévő mérkőzések szekciójában.
-   **Új mérkőzés létrehozása** (3 pont)
    -   Az **admin** felhasználó új mérkőzéseket is kiírhat.
    -   Az egyes mezőkre jellemző alapvető validációs feltételek mellett ellenőrizni kell, hogy a kezdés időpontja jövőbeli, illetve a hazai és vendég csapat nem azonos.
-   **Meglévő mérkőzés módosítása** (3 pont)
    -   Az **admin** felhasználó módosíthatja is a meglévő mérkőzéseket.
-   **Mérkőzés törlése** (1 pont)
    -   Az **admin** felhasználó törölheti is a meglévő mérkőzéseket, amennyiben még nincs esemény rögzítve az adott meccshez!
-   **Csapatok listája** (2 pont)
    -   Ezt az oldalt bárki (vendég, bejelentkezett, admin) megtekintheti.
    -   Az oldalon megjelenik az összes csapat neve, rövidítése és logója (ha van feltöltve, különben placeholder kép).
    -   A lista a csapatok neve szerint betűrendbe rendezve jelenik meg.
    -   Az egyes csapatokra kattintva továbblépünk az adott csapat részletező oldalára.
-   **Csapatrészletező oldal** (2 pont)
    -   A csapatrészletező oldalon két fontos információ kell megjelenjen:
        1. A csapat mérkőzései időrendi sorrendben. (Természetesen itt is fel kell tüntetni az eredményt a folyamatban lévő és befejezett meccsek esetében.)
        2. A csapatban lévő összes játékos adatai: neve, születési dátuma, statisztikái (hány gólt, öngólt rúgott, illetve hány sárga és piros lapot kapott).
-   **Új csapat hozzáadása** (4 pont)
    -   Az **admin** tudjon új csapatot felvenni a bajnokságba. Ehhez meg kell adjon minden kötelező adatot, de logó feltöltése opcionális!
    -   A logóhoz tartozó képfeltöltés **ténylegesen** legyen fájlfeltöltés, tehát nem elég csupán a kép nevét vagy egy külső URL-t eltárolni!
-   **Meglévő csapat módosítása** (4 pont)
    -   Az **admin** a csapat részletező oldaláról átlépve tudja módosítani is a felvett csapatok adatait és/vagy logóját.
    -   Ha már van feltöltött kép, és nem tölt fel fájlt, akkor maradjon meg az előző kép; különben értelemszerűen le kell cserélni.
-   **Új játékos felvétele** (2 pont)
    -   Az **admin** tudjon új játékost felvenni a csapatba annak részletező oldaláról indulva. Ehhez meg kell adjon minden kötelező adatot, tehát a játékos mezszámát, nevét és születési dátumát.
-   **Meglévő játékos törlése** (1 pont)
    -   Az **admin** tudjon törölni olyan játékosokat, akikhez nem tartozik még esemény egy meccsen sem. Tehát azokat a játékosokat, akik letettek már valamit az asztalra, nem töröljük a jegyzőkönyvekből!
-   **Tabella oldal** (4 pont)
    -   A tabella oldalon megjelenik a bajnokságban résztvevő összes csapat az elért pontszámuk szerinti sorrendben.
    -   Egy csapat pontszámát a befejezett mérkőzései alapján kell számítani a következő módon:
        -   nyert mérkőzés: +3 pont
        -   döntetlen: +1 pont
        -   vesztes mérkőzés: +0 pont
    -   Ha két csapat pontszáma a fentiek szerint azonos, akkor az kerüljön a sorrendben előrébb, akinek jobb a gólkülönbsége (szerzett gólokból kivonjuk a kapott gólok számát). Ha még mindig egyenlőség van, akkor a betűrendben előbb lévő csapat kerüljön feljebb a rangsorban.
-   **Kedvenceim oldal** (4 pont)
    -   Ez az oldal csak **bejelentkezett** felhasználók számára elérhető.
    -   A nem bejelentkezett felhasználóknak ajánljuk fel a bejelentkezés vagy regisztráció lehetőségét, amely természetesen működjön is megfelelően!
    -   A bejelentkezett felhasználók minden olyan helyen, ahol csapatnév vagy rövidítés szerepel (pl. meccsek, csapatok, tabella) kedvencnek tudják jelölni a csapatukat egy gombra vagy ikonra kattintva.
    -   A már kedvencnek jelölt csapat ugyanígy el is távolítható a kedvencek közül.
    -   A kedvenceim oldalon a bejelentkezett felhasználók csak azokat a mérkőzéseket látják, amelyben valamelyik kedvencnek jelölt csapatuk részt vesz.
-   **Védésre szerezhető pontszám** (4 pont)
    -   További 4 pont szerezhető a védés során mutatott **általános jártasságra** a témában.
    -   Nem várjuk el senkitől, hogy másfél-két hónap alatt mesterévé váljon a Laravel lelki világának; viszont azt igen, hogy a **saját projektjét** alapvetően tudja navigálni és a **gyakorlaton lefedett** ismeretekkel kapcsolatos kiegészítő kérdésekre tudjon értékelhetően válaszolni. Normál esetben a védés 15-20 percnél tovább nem tart.
    -   **Amennyiben a hallgató a szóbeli védés során teljes tájékozatlanságot mutat, az egész beadandó feladat visszautasítható!**

## Hasznos hivatkozások

Az alábbiakban adunk néhány hasznos hivatkozást, amiket érdemes szemügyre venni a beadandó elkészítésekor.

-   [Órai anyagok 2022/23/2](https://github.com/szerveroldali/2022-23-2)
-   [Laravel nyelvi csomag - magyarosításhoz](https://github.com/Laravel-Lang/lang) (opcionális)
-   Tantárgyi Laravel jegyzetek:
    -   [Laravel projektszerkezet](https://github.com/szerveroldali/leirasok/blob/main/LaravelProjektszerkezet.md)
    -   [Kimenet generálása](http://webprogramozas.inf.elte.hu/#!/subjects/webprog-server/handouts/laravel-01-kimenet)
    -   [Bemeneti adatok, űrlapfeldolgozás](http://webprogramozas.inf.elte.hu/#!/subjects/webprog-server/handouts/laravel-02-bemenet)
    -   [Adattárolás, egyszerű modellek](http://webprogramozas.inf.elte.hu/#!/subjects/webprog-server/handouts/laravel-03-adatt%C3%A1rol%C3%A1s)
    -   [Relációk a modellek között](http://webprogramozas.inf.elte.hu/#!/subjects/webprog-server/handouts/laravel-04-rel%C3%A1ci%C3%B3k)
    -   [Hitelesítés és jogosultságkezelés](http://webprogramozas.inf.elte.hu/#!/subjects/webprog-server/handouts/laravel-05-hiteles%C3%ADt%C3%A9s)
-   Hivatalos dokumentációk:
    -   [Laravel dokumentáció](https://laravel.com/docs)
        -   [Blade direktívák](https://laravel.com/docs/10.x/blade)
        -   [Resource Controllers](https://laravel.com/docs/10.x/controllers#resource-controllers)
        -   [Validációs szabályok](https://laravel.com/docs/10.x/validation#available-validation-rules)
        -   [Migrációknál elérhető mezőtípusok](https://laravel.com/docs/10.x/migrations#available-column-types)
    -   [Laravel API dokumentáció](https://laravel.com/api/master/index.html)
    -   [PHP dokumentáció](https://www.php.net/manual/en/)
    -   [Bootstrap 5 dokumentáció](https://getbootstrap.com/docs/)
-   Programok, fejlesztői eszközök:
    -   [PHP és Composer telepítő](https://github.com/totadavid95/PhpComposerInstaller) (php + composer)
    -   [Node.js](https://nodejs.org/en/download/) (node + npm)
    -   [Visual Studio Code](https://code.visualstudio.com/)
        -   [Live Share](https://marketplace.visualstudio.com/items?itemName=MS-vsliveshare.vsliveshare)
        -   [Laravel Extension Pack](https://marketplace.visualstudio.com/items?itemName=onecentlin.laravel-extension-pack)
        -   [SQLite Viewer](https://marketplace.visualstudio.com/items?itemName=qwtel.sqlite-viewer)
    -   [DB Browser for SQLite](https://sqlitebrowser.org/)
-   További CSS framework tippek (opcionális):
    -   [Tailwind CSS](https://tailwindcss.com/)
    -   [Material Bootstrap](https://mdbootstrap.com/)
    -   [Material UI, React-hez](https://material-ui.com/)
    -   [Fontawesome ikonkészlet](https://fontawesome.com/)
    -   [Bulma](https://bulma.io/)
