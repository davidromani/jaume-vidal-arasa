##########
# Config #
##########
set :application,       "CMS Jaume Vidal Arasa"
set :domain,            "s3.flux.cat"
set :deploy_to,         "/home/flux/webapps/jaumevidalarasa"
set :app_path,          "app"
set :cache_dir,         "/cache"
set :config_dir,        "/config"
set :logs_dir,          "/logs"
set :sessions_dir,      "/sessions"
set :web_path,          "web"
set :bundles_dir,       "/bundles"
set :uploads_dir,       "/uploads"
set :imagescache_dir,   "/imagescache"

##################
# SCM Repository #
##################
set :repository,        "git@bitbucket.org:dromani/cms-jaumevidalarasa.git"
set :scm,               :git
set :branch,            "master"

#######
# ORM #
#######
set :model_manager,     "doctrine"              # Or "propel"

#######
# Web #
#######
role :web,  domain                              # Your HTTP server, Apache/etc
role :app,  domain, :primary => true            # This may be the same as your `Web` server

##########
# Server #
##########
set :user,              "flux"
set :webserver_user,    "www-data"
set :use_sudo,          false
set :keep_releases,     3
set :deploy_via,        :remote_cache           # Don't clone the whole repository into releases/ dir on every deploy
set :use_composer,      true
set :vendors_mode,      'install'
set :update_vendors,    false                   # true = composer update | false = composer install

###############
# Shared dirs #
###############
set :shared_files,      [ app_path+config_dir+"/parameters.yml", web_path+"/.htaccess" ]
set :shared_children,   [ app_path+logs_dir, app_path+sessions_dir, web_path+bundles_dir, web_path+uploads_dir, web_path+imagescache_dir ]

###############
# Permissions #
###############
set :writable_dirs,         [ app_path+cache_dir, app_path+logs_dir, app_path+sessions_dir, web_path+bundles_dir, web_path+uploads_dir, web_path+imagescache_dir ]
set :permission_method,     :acl
set :use_set_permissions,   true

##############
# Procedures #
##############
namespace :phpcr do
    desc "Execute initial PHPCR setup"
    task :init do
        run "cd #{release_path} && php app/console doctrine:database:create && php app/console doctrine:phpcr:init:dbal && php app/console doctrine:phpcr:repository:init && php app/console doctrine:phpcr:fixtures:load -n"
    end
end

############
# Triggers #
############
#before "symfony:cache:warmup", "phpcr:init" # Enable this line only when deploy FIRST time
after "deploy", "deploy:cleanup"

###########
# Logging #
###########
#logger.level = Logger::MAX_LEVEL               # Be more verbose by uncommenting this line
