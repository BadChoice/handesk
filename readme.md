# Handesk

## Description
Handesk has been created by our need (At Revo Systems www.revo.works) to have a powerful yet simple Ticketing system, we needed a system that allowed us to
have multiple teams, with multiple users, easy and efficient reporting by all/team/user as well as lead management.

[Landing page: http://handesk.io](http://handesk.io)

Check out the screenshots to see how nice it looks, and feel free to contribute by sending us PRs.
We will keep adding features as we need them, but our basic workflow is totally covered :D

## Features
- Email polling (new tickets and tickets updates)
- Email attachments as ticket attachments (using laravel storage driver)
- API for creating/updating/fetching tickets/leads so you can display them into your main app
- Instant email/slack notifications when tickets are created/updated
- Everything is unlimited
- Lead management (With its API as well)
- Auto lead subscription to mailChimp based on its tags
- Tickets reporting
- Tickets internal notes
- Tickets can be escalated, so assistants can comment on them to help the teams
- Can merge tickets
- Mention agents with @name so they get notified
- Lead tasks, that can have a due date, and sending daily tasks email
- Create issues to your code repository directly from the ticket
- Updating the ticket automatically when an issue is marked as resolved
- UI multi language support (default en, alternative ca, de, fr, es)
- Roadmap module, you can create ideas that come from your customers or your own, give them deadlines and integrate them with your repository manager,
you can even create ideas from support tickets so you never lose track.
- You can also create ideas by sending an email to you support accounts starting with `Idea:` it will create an idea instead of a ticket
- Ticket rating, when a ticket is solved a rating email is sent to the customer (check config/handesk.php to disable it)

> Follow us on twitter [@codepassionapp](https://twitter.com/codepassionapp) to stay tuned


## Installation
Its very simple, you just need to follow the standard Laravel installation

```shell
git clone https://github.com/BadChoice/handesk.git
cd handesk
composer install
# Setup your .env file to match your desired database
php artisan key:generate

# Purge the cache before running migrations
php artisan config:cache
php artisan config:clear

# Run migrations and seed
php artisan migrate --seed
php artisan storage:link #if you use the local driver
```

Alternatively, you can use the following [docker setup](https://github.com/BadChoice/handesk/blob/dev/docker-installation.md)


> The default admin user is admin@handesk.io / admin
> If you want email pulling, you need to enable the `imap` extension on php (note that on mac the php-cli runs very slow, you need to update your /etc/hosts file

```
::1         localhost YourMac.local
127.0.0.1   localhost YourMac.local
```

Open your `app/Console/Kernel.php` to update the schedulers as you want (comment them if not needed)
Add the cron job `* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1`

### Further configuration
#### Email pulling
Enter your mail credentials in .env

````
MAIL_FETCH_HOST=pop3.handesk.com
MAIL_FETCH_PORT=110
MAIL_FETCH_USERNAME=hello@handesk.com
MAIL_FETCH_PASSWORD=secret-password
````

### Sidebar
You can toggle the visibility of `leads` and `ideas` in the `config/handesk.php` file.
```
'leads'    => env('HANDESK_LEADS_ENABLED', true),
'roadmap'  => env('HANDESK_ROADMAP_ENABLED', true),
```

#### Mailchimp
Set your mailchimp key in .env
`MAILCHIMP_API_KEY=448027f3acac5594605be3adf78be862-us15`

And enter the relation of `tags => list` id in `config/services.php` mailchimp section

#### Bitbucket
You can create issues directly to your code repository from tickets. You need to setup your credentials in the .env
```
BITBUCKET_USER=bitbucket-user-if-using-basic-auth
BITBUCKET_PASSWORD=bitbucket-password-if-using-basic-auth
```

And enter your repositories list in `config/issues.php` file, filling the `repositories` field.

You can event update the tickets automatically (adding a private note using bitbucket webhooks).
You just need to go to your report webhooks settings and add a new webhook with the url

`http://{handesk.io}/webhook/bitbucket`

You just need to check the `issues updated` option


#### Api Token
Set your desired API token in the .env

```API_TOKEN=the-api-token```

We have the following SDK's to easily interact with Handesk api
There is the `badchoice/handesk-php` package in packagist to easily talk with the api.
[Handesk-php](https://github.com/BadChoice/handesk-php)
[Handesk-ios](https://github.com/BadChoice/handesk-ios) *In progress*

### Screenshots
![Tickets screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/tickets.png)
![Ticket screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/ticket.png)
![Leads screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/leads.png)
![Lead screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/lead.png)
![Invitation screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/invitation.png)
![Email screenshot](https://raw.githubusercontent.com/BadChoice/handesk/master/resources/screenshots/email.png)

## Community
We have a slack channel at [https://handesk.slack.com/](https://handesk.slack.com)
And you can join with the following [invitation](https://handesk.slack.com/shared_invite/enQtMzQwMTg5ODkwNDUxLWVhYjFkNzNkMmE2NWUxYjcwZTNhMmM0M2M3NmVkMzdhNWI0NTU0ZGM0ODFlNTVlMGZhMTA0YzM0YjA3NjcxMTc)

Join in with the following link

[Join handesk slack](https://join.slack.com/t/handesk/shared_invite/enQtMzg4MzE4ODcwNzg2LTlmZTk4NGRjZDA5N2ExYTI2ZDhhNzAyOThmMDM1YjgwZTMzZTQ5ZjkxNDVlNzIwY2ZkZWExN2U2NDUwNWFiOWU)

Or you can follow me on twitter too
[@codepassionapp](https://twitter.com/codepassionapp)

Even at instragram [codepasssion.io](https://www.instagram.com/codepassion.io/)


## Development
We try to follow a TDD approach as well as some mixed functional CSS for the frontend.

**PRs are welcome!**

## License
Handesk is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Special thanks to [Jetbrains](https://www.jetbrains.com) for their support to open source projects!
