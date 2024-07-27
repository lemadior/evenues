# Evenues
Test project realized functionality for managing two entities 
(events and venues), accessible only to the site administrator, 
as well as for interacting with the weather service API.

The project supposed to be started on Linux (any distro).

Before start the docker-compose must be installed into the system.

## Install the project

0. Unpack or clone source code.

1. Change the owner and permission for the project directory:

```sudo chown -R 1000:33 $(pwd)```

2. Install the stuff:

At first copy the ```.env.example``` file and specify properly
values for variables concerns database, weather service authkey
and so on..

    WEATHER_LOCATION_SERVICE_AUTHKEY=
    DB_USERNAME=
    DB_PASSWORD=
    DB_ROOT_PASSWORD=


After that just run command:

```docker-compose up -d```

3. Update the composer

```docker exec -it app composer install```

4. Create new application key:

```docker exec -it app php artisan key:generate --ansi```

5. Create symlink to the public storage folder:

```docker exec -it app php artisan storage:link ```

6. Fill database with the test data:

```docker exec -it app php artisan migrate --seed```

Through seeding an only user 'admin' will be created. But one can
register as many users into the system as possible.

7. Checking the service:

Try to run service by address: ```http://localhost:5000```

After first log in attempt the service try to determine geographical
location and store it into the session. At the same time, used
this geographical data service try to get weather data. If it succeeded
the weather data will save into teh Redis.

One can create new Event, edit or delete it. The Venues can
be created, edited or deleted too. The weather data depends on
event's date only. Venue is just the fake string and means nothing.

