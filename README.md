# PHP TC Kimlik

Bu kütüphaneyi kullanarak basit ve hızlı bir şekilde kimlik kontrolleri yapın.
Örnek bir kullanım:

````php
use DateTime;
use IsaEken\PhpTcKimlik\PhpTcKimlik;

$sonuc = PhpTcKimlik::isValidIdentity("tckimlikno", "ad", "soyad", new DateTime("dogum tarihi"));
````

---

![PHP TC Kimlik](https://banners.beyondco.de/TC%20Kimlik.jpeg?theme=light&packageManager=composer%20require&packageName=isaeken/php-tc-kimlik&pattern=architect&style=style_1&description=TC%20kimlik%20kontrol%20i%C5%9Flemleri&md=1&showWatermark=0&fontSize=150px&images=https://www.php.net/images/logos/php-logo.svg)

## Kurulum

Composer kullanarak basit bir şekilde projenize ekleyebilirsiniz:
````shell
composer require isaeken/php-tc-kimlik
````

## Kullanım

### Laravel

> Türkçe dil için ``config/app.php`` dosyasında ``locale`` değişkenini ``tr`` yapın.

#### Kimlik Numarası

````php
public function index(Request $request)
{
    $request->validate([
        'tc_kimlik_numarasi' => [new IsaEken\PhpTcKimlik\Rules\IdentityNumber],
    ]);
}
````

#### İsim Kontrolü

````php
public function index(Request $request)
{
    $request->validate([
        'isim' => [new IsaEken\PhpTcKimlik\Rules\RealName],
        'soyisim' => [new IsaEken\PhpTcKimlik\Rules\RealName],
    ]);
}
````

#### Yıl Kontrolü

````php
public function index(Request $request)
{
    $request->validate([
        'dogum_yili' => ['required', new IsaEken\PhpTcKimlik\Rules\RealYear],
    ]);
}
````

#### Kimlik Kontrolü

````php
public function index(Request $request)
{
    $request->validate([
        'tc_kimlik_numarasi' => ['required', new IsaEken\PhpTcKimlik\Rules\IdentityNumber],
        'isim' => ['required', new IsaEken\PhpTcKimlik\Rules\RealName],
        'soyisim' => ['required', new IsaEken\PhpTcKimlik\Rules\RealName],
        'dogum_yili' => ['required', new IsaEken\PhpTcKimlik\Rules\RealYear],
    ]);

    $validator = new IsaEken\PhpTcKimlik\IdentityValidator(
        "tc_kimlik_numarasi", // varsayılan: identity_number
        "isim", // varsayılan: first_name
        "soyisim", // varsayılan: last_name
        "dogum_yili", // varsayılan: birth_year
        "post", // opsiyonel method
        $request // opsiyonel
    );
    
    $validator->validate();
}
````

Örnek:
````php
public function index(Request $request)
{
    $request->validate([
        'identity_number' => ['required', new IsaEken\PhpTcKimlik\Rules\IdentityNumber],
        'first_name' => ['required', new IsaEken\PhpTcKimlik\Rules\RealName],
        'last_name' => ['required', new IsaEken\PhpTcKimlik\Rules\RealName],
        'birth_year' => ['required', new IsaEken\PhpTcKimlik\Rules\RealYear],
    ]);

    ((new IsaEken\PhpTcKimlik\IdentityValidator())->validate());
}
````


----

### Hızlı kullanım

#### Kimlik bilgilerinin kontrolü

Kimlik bilgilerini kontrol etmek için kişinin; kimlik numarası, adı, soyadı ve doğum yılı olmalıdır.
Basit bir şekilde bu bilgiler ile örnekteki kodu kullanarak bir doğrulama yapabilirsiniz.
````php
// değişkenler sırası ile; kimlik numarası, adı, soyadı, doğum tarihi.
// doğum tarihi DateTimeInterface olmalıdır eğer gün ve ay girilmek istenmezse rastgele gün ay belirtilebilir çünkü bu işlemde sadece doğum yılı kullanılacaktır: new DateTime("01.01.2000")
IsaEken\PhpTcKimlik\PhpTcKimlik::isValidIdentity("123456789", "isa", "eken", new DateTime("10.04.2002"));
````

#### Yabancı kimlik bilgilerinin kontrolü

Kimlik bilgilerini kontrol ederken kullanılan herşey bu işlem içinde geçerlidir. Bu işlemde kimlik numarasına syntax kontrolü yapılmaz ve direkt olarak nvi'den kimlik kontrolü yapılır.
````php
IsaEken\PhpTcKimlik\PhpTcKimlik::isValidForeignIdentity("123456789", "isa", "eken", new DateTime("10.04.2002"));
````

#### Kimlik kart bilgilerinin kontrolü

Kimlik kartı bilgilerini kontrol etmek için kişinin; kimlik numarası, kart seri numarası, adı, soyadı ve doğum tarihi olmalıdır.
````php
IsaEken\PhpTcKimlik\PhpTcKimlik::isValidIdentityCard(
    "123456789", // kimlik numarası
    "xxxxxxxxx", // seri numarası
    "isa", // ad
    "eken", // soyad
    new DateTime("10.04.2002") // doğum tarihi. gün, ay ve yıl gerekli
);
````

### Detaylı kullanım ve kimlik arayüzü

#### Kimlik arayüzü

Tüm işlemlerden önce ilk olarak kimlik sınıfını kullanarak bir kimlik oluşturmalısınız.
````php
$kimlik = new \IsaEken\PhpTcKimlik\PhpTcKimlik;
````

bu sınıfa kişinin kimlik bilgilerini chained fonksiyonlar ile verebilirsiniz. Varsayılan değerler boş olacaktır.

Verileri almak için kullanabileceğiniz fonksiyonlar:
````php
$kimlik->getIdentityNumber(); // string olarak kişinin kimlik numarasını döndürür.
$kimlik->getSurname(); // string olarak kişinin soyadını döndürür.
$kimlik->getGivenName(); // string olarak kimlik adını döndürür.
$kimlik->getBirthDate(); // DateTimeInterface olarak kişinin doğum tarihini döndürür.
$kimlik->getGender(); // string olarak kişinin cinsiyetini döndürür.
$kimlik->getDocumentNumber(); // string olarak kişinin kimlik kartının seri numarasını döndürür.
$kimlik->getNationality(); // string olarak kişinin uyruğunu döndürür.
$kimlik->getValidUntil(); // DateTimeInterface olarak kişinin kimliğinin son geçerlilik tarihini döndürür.
$kimlik->getMotherName(); // string olarak kişinin anne adını döndürür.
$kimlik->getFatherName(); // string olarak kişinin baba adını döndürür.
$kimlik->getIssuedBy(); // string olarak kişinin kimliğini veren makanım adını döndürür.
````

Verileri uygulamak için kullanabileceğiniz fonksiyonlar. Tüm fonksiyonlar ``IdentityCardInterface`` dönecektir, yani tüm fonksiyonları ard arda kullanabilirsiniz (chianed).
````php
$kimlik->setIdentityNumber("12345678910"); // kimlik numarasını değiştir.
$kimlik->setSurname("Soyadı"); // soyadı değiştir.
$kimlik->setGivenName("Adı"); // adı değiştir.
$kimlik->setBirthDate(new DateTime("01.28.2021")); // doğum tarihini değiştir.
$kimlik->setGender("E / M"); // cinsiyeti değiştir.
$kimlik->setDocumentNumber("xxxxxxxxx"); // seri numarasını değiştir.
$kimlik->setNationality("T.C./TUR"); // uyruğu değiştir.
$kimlik->setValidUntil(new DateTime("01.28.2021")); // son geçerlilik tarihini değiştir.
$kimlik->setMotherName("Annesi"); // anne adını değiştir.
$kimlik->setFatherName("Babası"); // bana adını değiştir.
$kimlik->setIssuedBy("T.C."); // kimliği veren makamım adını değiştir.
````

#### Kontroller

Oluşturulan kimliği kullanarak kontrolleri yapabilirsiniz.

##### Kimlik kontrolü

Kimlik numarası, ad, soyad ve doğum yılını kullanarak nvi üzerinden bir kontrol yapmak için:
````php
$kimlik->validateIdentityNumber(); // boolean
````

Yabancı kimlik numarası, ad, soyad ve doğum tarihi kullanarak nvi üzerinden bir kontrol yapmak için:
````php
$kimlik->validateForeignIdentityNumber(); // boolean
````

Kimlik numarası, kimlik seri numarası, ad, soyad ve doğum tarihi kullanarak nvi üzerinden kimlik kartı kontrolü yapmak için:
````php
$kimlik->validateIdentityCard(); // boolean
````

##### Örnekler

Kimlik numarası / Yabancı kimlik numarası kontrolü
````php
$kimlik = new IsaEken\PhpTcKimlik\PhpTcKimlik;
$kimlik->setIdentityNumber("12345678910");
$kimlik->setGivenName("ad");
$kimlik->setSurname("soyad");
$kimlik->setBirthDate(new DateTime("28.04.2021"));
$kimlik->validateIdentityNumber(); // kimlik numarası kontrolü
$kimlik->validateForeignIdentityNumber(); // yabancı kimlik numarası kontrolü
````

Kimlik kartı kontrolü
````php
(new IsaEken\PhpTcKimlik\PhpTcKimlik)
    ->setIdentityNumber("12345678910")
    ->setDocumentNumber("xxxxxxxxx")
    ->setGivenName("ad")
    ->setSurname("soyad")
    ->setBirthDate(new DateTime("28.04.2021"))
    ->validateForeignIdentityNumber();
````

### Yardımcı fonksiyonlar

````php
use IsaEken\PhpTcKimlik\Helpers;

// yazıyı Türkçe karakterleri dikkate alarak küçük harflere çevirir.
Helpers::lower("TÜRKÇE"); // türkçe

// yazıyı Türkçe karakterleri dikkata alarak büyük harflere çevirir.
Helpers::upper("türkçe"); // türkçe

// kimlik numarasının syntaxının doğruluğunu kontrol eder.
Helpers::verifyIdentity("12345678910"); // true
Helpers::verifyIdentity("00987654321"); // false

// Türkçe karakterler içeren bir isimin syntaxını kontrol eder.
Helpers::verifyName("ata"); // true
Helpers::verifyName("!'\""); // false

// değişkenin bir yılı ifade edip etmediğini kontrol eder.
Helpers::verifyYear(1881); // true
Helpers::verifyYear("1881"); // true
Helpers::verifyYear(-15); // false
Helpers::verifyYear("-15"); // false
Helpers::verifyYear("www"); // false

/**
 * Verify year is valid.
 *
 * @param int|string $year
 * @param int $min
 * @param int $max
 * @return bool
 */
Helpers::verifyYear("2000", 2000, 3000); //  true
````

## Testler

````shell
composer test
````

## Lisans

Bu yazılım MIT lisansı altında dağıtılmaktadır. [Lisans Dosyasını](https://github.com/isaeken/php-tc-kimlik/blob/master/LICENSE.md) inceleyin.
