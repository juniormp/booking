## Project Setup


Create `.env` file

- Copy the `.env.example` file to a new `.env` file

Start Laravel Sail

- `./vendor/bin/sail up`

Run Migrations

- `./vendor/bin/sail php artisan migrate`

Run Unit and Feature Testing

- `./vendor/bin/sail php artisan test`

Run Server

- `./vendor/bin/sail php artisan serve`

Test Endpoints

- [POST] http://0.0.0.0:80/api/booking/createBooking
- [UPDATE] http://0.0.0.0:80/api/booking/updateBooking
- [GET] http://0.0.0.0:80/api/booking/daily-occupancy-rates/2022-01-02?rooms[]=97f881a4-a6d0-470c-a5a3-9b4e6712756e&rooms[]=97f881a4-a6f6-48be-85af-26d72bc46950
- [GET] http://0.0.0.0:80/api/booking/monthly-occupancy-rates/2022-01?rooms[]=97f881a4-a6d0-470c-a5a3-9b4e6712756e&rooms[]=97f881a4-a6f6-48be-85af-26d72bc46950
