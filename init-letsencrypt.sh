#!/bin/bash
# Run this script ONCE on the server before starting docker compose for the first time.
# It provisions a Let's Encrypt certificate for stugooo.com using the webroot challenge.

set -e

DOMAIN="stugooo.com"
EMAIL="studgooo@gmail.com"
STAGING=0  # Set to 1 to test with Let's Encrypt staging (avoids rate limits)

echo "### Creating certbot directories..."
mkdir -p ./certbot/conf/live/$DOMAIN ./certbot/www

echo "### Generating temporary self-signed certificate so nginx can start..."
openssl req -x509 -nodes -newkey rsa:2048 -days 1 \
  -keyout ./certbot/conf/live/$DOMAIN/privkey.pem \
  -out    ./certbot/conf/live/$DOMAIN/fullchain.pem \
  -subj   "/CN=localhost" 2>/dev/null

echo "### Starting nginx with temporary certificate..."
docker compose up --force-recreate -d nginx
sleep 5

echo "### Removing temporary certificate..."
rm -rf ./certbot/conf/live/$DOMAIN

echo "### Requesting Let's Encrypt certificate..."
STAGING_ARG=""
if [ "$STAGING" -ne 0 ]; then
  STAGING_ARG="--staging"
fi

docker compose run --rm certbot certonly --webroot \
  -w /var/www/certbot \
  $STAGING_ARG \
  -d $DOMAIN \
  -d www.$DOMAIN \
  --email "$EMAIL" \
  --agree-tos \
  --no-eff-email

echo "### Reloading nginx with real certificate..."
docker compose exec nginx nginx -s reload

echo "### Starting all remaining services..."
docker compose up -d

echo ""
echo "Done! Your site should now be live at https://$DOMAIN"
