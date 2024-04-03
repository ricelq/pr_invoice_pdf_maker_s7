<span id="readme-top"></span>

<div align="center">

<h3 align="center">Symfony 7 Invoice PDF Maker</h3>

  <p align="center">
      Invoice PDF Maker is a Symfony 7 project designed to efficiently 
      manage and generate invoices that can be printed and downloaded as PDF. 
      With customizable fields such as VAT, currency and logo placement, 
      this project offers flexibility to meet diverse invoicing needs.
      <br /><br />
   </p>
</div>




<!-- GETTING STARTED -->

## Getting Started

### Prerequisites

* PHP 8.2
* MySQL
* Composer
* Symfony-cli

### Installation

Clone this repository to your local machine:

1. Clone the repo
   ```sh
   git clone https://github.com/ricelq/pr_invoice_pdf_maker_s7.git
   ```

2. Install dependencies via composer
   <br>(Download [composer](https://getcomposer.org) if not yet installed)
   ```sh
   composer install
   ```

3. Edit the .env file with your USERNAME, PASSWORD AND DATABASENAME
   ```sh
   DATABASE_URL="mysql://USERNAME:PASSWORD@127.0.0.1:3306/DATABASENAME?charset=utf8mb4"
   ```

4. Create database
   ```sh
   php bin/console doctrine:database:create
   ```

5. Migrate data to database
   ```sh
   php bin/console doctrine:migrations:migrate
   ```      

6. Load data fixtures
   ```sh
   composer run fixtures
   ```

7. Build assets
   ```sh
   composer run build
   ```   

8. Run application
   ```sh
   symfony server:start
   then visit page at https://127.0.0.1:8000
   then login as administrator
        email: admin@domain.com 
        password: admin
   ```   

## Enabled Bundles

 Concern        | Bundles                                                                                       
----------------|-----------------------------------------------------------------------------------------------
 security       | [`symfony/security-bundle`](https://github.com/symfony/security-bundle)                       
 reset-password | [`symfonycasts/reset-password-bundle`](https://github.com/SymfonyCasts/reset-password-bundle) 
 verify-email   | [`symfonycasts/verify-email-bundle`](https://github.com/SymfonyCasts/verify-email-bundle)     
 mailer         | [`symfony/mailer`](https://github.com/symfony/mailer)                                         
 http-client    | [`symfony/http-client`](https://github.com/symfony/http-client)                               
 maker-bundle   | [`symfony/maker-bundle`](https://github.com/symfony/maker-bundle)                             
 asset mapper   | [`symfony/asset-mapper`](https://github.com/symfony/asset-mapper)                             
 twig engine    | [`symfony/twig-pack`](https://github.com/symfony/twig-pack)                                   
 easyadmin      | [`easycorp/easyadmin-bundle`](https://github.com/EasyCorp/EasyAdminBundle)                    
 fixtures       | [`doctrine/doctrine-fixtures-bundle`](https://github.com/doctrine/DoctrineFixturesBundle)     
 vich-uploader  | [`vich/uploader-bundle`](https://packagist.org/packages/vich/uploader-bundle)                             
 pdf-invoice       | [`konekt/pdf-invoice`](https://packagist.org/packages/konekt/pdf-invoice)                             

## Screenshots


### Invoices list

![img_4.png](img_4.png)

![img_5.png](img_5.png)

![img_1.png](img_1.png)

### Invoice edit
![img_6.png](img_6.png)

### Invoice PDF
![img_9.png](img_9.png)

### Partners (Addresses)
![img_7.png](img_7.png)

<!-- CONTACT -->

## Contact

Ricel Quispe - [@linkedin](https://www.linkedin.com/in/ricelquispe) - ricel@prodeimat.ch

Project Link: [https://github.com/ricelq/pr_invoice_pdf_maker_s7](https://github.com/ricelq/pr_invoice_pdf_maker_s7)

<p align="right">(<a href="#readme-top">back to top</a>)</p>
