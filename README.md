<p align="center"><a href="https://github.com/trivakamer/Backend"><img src="https://rawcdn.githack.com/CubeQuence/CubeQuence/855a8fe836989ca40c4e50a889362975eab9ac43/public/assets/images/banner.png"></a></p>

<p align="center">
<a href="https://github.com/trivakamer/backend/commits/master"><img src="https://img.shields.io/github/last-commit/trivakamer/backend" alt="Latest Commit"></a>
<a href="https://github.com/trivakamer/backend/issues"><img src="https://img.shields.io/github/issues/trivakamer/backend" alt="Issues"></a>
<a href="LICENSE.md"><img src="https://img.shields.io/github/license/trivakamer/backend" alt="License"></a>
</p>

# Trivakamer

Trivakamer website code

- [Homepage](https://trivakamer.nl)

## Installation

For development

1. `git clone https://github.com/trivakamer/backend.git`
2. `composer install`
3. Edit `.env`
4. `php cubequence app:key`
5. `php cubequence db:migrate`
6. `php cubequence db:seed`
7. Start development server `php -S localhost:8080 -t public`

For production

1. `git clone https://github.com/trivakamer/backend.git`
2. `composer install --optimize-autoloader --no-dev`
3. Edit `.env`
4. `php cubequence app:key`
5. `php cubequence db:migrate`

## Security Vulnerabilities

Please review [our security policy](https://github.com/trivakamer/backend/security/policy) on how to report security vulnerabilities.

## License

Copyright © 2021 [Trivakamer](https://github.com/trivakamer). <br />
This project is [MIT](LICENSE.md) licensed.
