# Symfony Temel Kullanımı

### Gereksinimler
- php => 8.0
- Symfony `scoop install symfony-cli`
- composer, eğer composer install değilse `symfony composer ...`
- twig install ->  `symfony composer require twig`
- secure bundle install -> `symfony composer require symfony/security-bundle`

### Get Started

- Symfony projesi oluşturmak için aşağıdaki komutu kullanın:

``` shell
symfony new proje_adi
```

- Proje klasörüne gidin:

``` shell
cd proje_adi
```

- Symfony projenizi başlatmak için yerel bir web sunucusu kullanabilirsiniz:

``` shell
symfony server:start
```


## Controller ve Route (Yol) Oluşturma

- Bir controller oluşturun. Örneğin, src/Controller/MerhabaController.php adında bir controller oluşturabilirsiniz:

``` php
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MerhabaController
{
    #[Route('/merhaba')]
    public function index(): Response
    {
        return new Response('Merhaba, Symfony!');
    }
}
```

- Şimdi bu controller'ı bir route (yol) ile ilişkilendirin. Bu işlemi config/routes.yaml dosyasında yapabilirsiniz:

``` yaml
merhaba:
    path: /merhaba
    controller: App\Controller\MerhabaController::index
```

#### php bin/console
- rotaları görmek için -> `php bin/console debug:router`
- user oluşturmak için -> `php bin/console make:user` (Eğer maker-bundle kurulu değilde ` symfony composer require symfony/maker-bundle --dev`)
- database oluşturma -> `php bin/console doctrine:database:create` (Gerekebilir -> `symfony composer require symfony/orm-pack`)
- `php bin/console doctrine:schema:update` --force
- değişiklikleri yeni sütunları vs dbye ekleme `php bin/console doctrine:migrations:diff` ardından 
- `php bin/console doctrine:migrations:migrate`

### Don't forget

- DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8" on .env
- example `DATABASE_URL="postgresql://postgres:240530@localhost:5432/my-symfony-project"`


### Yeni bir entity oluşturulduğunda veya var olanlarında değişiklik yapıldığında

```shell
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```