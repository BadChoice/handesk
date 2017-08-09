### Handesk

## Description
Handesk has been created by our need (At Revo Systems www.revo.works) to have a powerful yet simple Ticketing system, we needed a system that allowed us to
have multiple teams, with multiple users, easy and efficient reporting by all/team/user as well as lead management.

Check out the screenshots to see how nice it looks, and feel fee to contribute by sending us PRs.
We will keep adding features as we need them, but our basic workflow is totally covered :D

## Features
· Email polling
· API for creating/updating/fetching tickets/leads so you can display them into your main app
· Instant email/slack notifications when tickets are created/updated
· Everything is unlimited 
· Lead management (With its API as well)
· Tickets reporting 

## Installation
Its very simple, you just need to follow the standard Laravel installation
```
git clone https://github.com/BadChoice/handesk.git
composer install
php artisan key:generate
# Setup your .env file to match you desired database
php artisan migrate --seed
```

> The default admin user is admin@handesk.com / admin
> If you want email pulling, you need to enable the `imap` extension on php (note that on mac the php-cli runs very slow, you need to update your /etc/hosts file 

```
::1         localhost YourMac.local
127.0.0.1   localhost YourMac.local
```

Open your `app/Console/Kernel.php` to update the schedulers as you want (event comment them if not needed)
Add the cron job `* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1`

## Development
We try to follow a TDD approach as well as some mixed functional CSS for the frontend.

TODOS:
2. Reports by (all, teams, user) 
 - Satisfaction ratio
 
3. Leads
