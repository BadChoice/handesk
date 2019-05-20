@setup
require __DIR__.'/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
try {
$dotenv->load();
$dotenv->required(['DEPLOY_SERVER', 'DEPLOY_REPOSITORY', 'DEPLOY_PATH'])->notEmpty();
} catch ( Exception $e )  {
echo $e->getMessage();
}

$server = getenv('DEPLOY_SERVER');
$repo = getenv('DEPLOY_REPOSITORY');
$path = getenv('DEPLOY_PATH');
$slack = getenv('DEPLOY_SLACK_WEBHOOK');
$healthUrl = getenv('DEPLOY_HEALTH_CHECK');

if ( substr($path, 0, 1) !== '/' ) throw new Exception('Careful - your deployment path does not begin with /');

$date = ( new DateTime )->format('Y-m-d_H:i:s');
$env = isset($env) ? $env : "production";
$branch = isset($branch) ? $branch : "master";
$path = rtrim($path, '/');
$release = $path.'/'.$date;
@endsetup


@servers(['web' => $server])
{{--@servers(['localhost' => '127.0.0.1'])--}}

@task('init')
if [ ! -d {{ $path }}/current ]; then
cd {{ $path }}
git clone {{ $repo }} --branch={{ $branch }} --depth=1 -q {{ $release }}
echo "Repository cloned"
mv {{ $release }}/storage {{ $path }}/storage
ln -s {{ $path }}/storage {{ $release }}/storage
ln -s {{ $path }}/storage/public {{ $release }}/public/storage
echo "Storage directory set up"
cp {{ $release }}/.env.example {{ $path }}/.env
ln -s {{ $path }}/.env {{ $release }}/.env
echo "Environment file set up"
rm -rf {{ $release }}
echo "Deployment path initialised. Run 'envoy run deploy' now."
else
echo "Deployment path already initialised (current symlink exists)!"
fi
@endtask

@story('deploy')
deployment_git
deployment_links
deployment_composer
deployment_migrate
deployment_cache
deployment_update_current
health_check
deployment_option_cleanup
@endstory

@story('deploy_cleanup')
deployment_git
deployment_links
deployment_composer
deployment_migrate
deployment_cache
deployment_update_current
health_check
deployment_cleanup
@endstory

@story('rollback')
deployment_rollback
health_check
@endstory

@task('deployment_git')
cd {{ $path }}
echo "Deployment ({{ $date }}) started"
git clone {{ $repo }} --branch={{ $branch }} --depth=1 -q {{ $release }}
echo "Repository cloned"
@endtask

@task('deployment_links')
cd {{ $path }}
rm -rf {{ $release }}/storage
ln -s {{ $path }}/storage {{ $release }}/storage
ln -s {{ $path }}/storage/public {{ $release }}/public/storage
echo "Storage directories set up"
ln -s {{ $path }}/.env {{ $release }}/.env
echo "Environment file set up"
@endtask

@task('deployment_composer')
echo "Installing composer depencencies..."
cd {{ $release }}
composer install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
@endtask

@task('deployment_migrate')
php {{ $release }}/artisan migrate --env={{ $env }} --force --no-interaction
@endtask

@task('deployment_cache')
php {{ $release }}/artisan view:clear --quiet
php {{ $release }}/artisan cache:clear --quiet
php {{ $release }}/artisan config:cache --quiet
php {{ $release }}/artisan queue:restart --quiet
echo 'Cache cleared'
@endtask

@task('deployment_update_current')
ln -nfs {{ $release }} {{ $path }}/current
chmod -R 777 {{ $path }}/storage
echo "Deployment ({{ $date }}) finished"
@endtask

@task('deployment_cleanup')
cd {{ $path }}
#find . -maxdepth 1 -name "20*" -mmin +2880 | head -n 5 | xargs rm -Rf
find . -maxdepth 1 -name "20*" | sort | head -n -4 | xargs rm -Rf
echo "Cleaned up old deployments"
@endtask

@task('deployment_option_cleanup')
cd {{ $path }}
@if ( isset($cleanup) && $cleanup )
    #find . -maxdepth 1 -name "20*" -mmin +2880 | head -n 5 | xargs rm -Rf
    find . -maxdepth 1 -name "20*" | sort | head -n -4 | xargs rm -Rf
    echo "Cleaned up old deployments"
@endif
@endtask


@task('health_check')
if [ "$(curl --write-out "%{http_code}\n" --silent --output /dev/null {{ $healthUrl }})" == "200" ]; then
printf "\033[0;32mHealth check to {{ $healthUrl }} OK\033[0m\n"
else
printf "\033[1;31mHealth check to {{ $healthUrl }} FAILED\033[0m\n"
fi
@endtask


@task('deployment_rollback')
cd {{ $path }}
ln -nfs {{ $path }}/$(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1) {{ $path }}/current
echo "Rolled back to $(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1)"
@endtask


@finished
@slack($slack, '#support', "Deployment on {$server}: {$date} complete")
@endfinished

