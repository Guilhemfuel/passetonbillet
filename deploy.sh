
# Pull the latest changes from the git repository
# git reset --hard
# git clean -df
echo "Pulling from master..."
git pull origin master
echo " Done."

# Install/update composer dependencies
echo "Installing composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
echo " Done."

# Run database migrations
echo "Database migration..."
php artisan migrate --force
echo " Done."

# Clear caches
echo "Clearing and updating caches..."
php artisan cache:clear

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache config
php artisan config:clear
#php artisan config:cache

# Clear and cache config
php artisan view:clear
php artisan view:cache
echo " Done."

# Install node modules
echo "Installing npm dependencies..."
npm install
echo " Done."

# Generate required files
echo "Generating language file and sitemap..."
php artisan ptb:generate-language
php artisan ptb:generate-sitemap
echo "Done."de

# Build assets using Laravel Mix
echo "Running npm run prod..."
npm run production
echo " Done."

# Restart queues
echo "Restarting queues..."
supervisorctl restart ptb-worker:*
echo "Done."
echo "Deployment done."
