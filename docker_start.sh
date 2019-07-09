docker-compose up -d;
docker exec liverepo_test_1 sh -c "cd /var/www/liverepo-demo/current && pm2 start npm --name "nuxt" -- run dev";