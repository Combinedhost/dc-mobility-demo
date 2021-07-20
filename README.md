Documentation link:

https://documenter.getpostman.com/view/12152243/TzsWt9pb

Please follow the below instructions before testing api:

1)Run php artisan migrate:fresh command.

2)Run php artisan db:seed command.

3)Add the following variables to the env:

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourname@gmail.com
MAIL_NAME=your-name
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls

ADMIN_USERNAME=admin_name
ADMIN_MAIL=admin@gmail.com

Note:

Dynamic variable usage syntax in template: {dynamic_variable}

Dynamic variables used:

* first_name

* last_name

* email

* phone

* address_line_1

* address_line_2

* city

* state

* country

* postcode
