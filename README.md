<h1 align="center">
Jobsity ChatBot App
</h1>
<h3 align="center">
    ChatBot application that allows user to manage his digital wallet, performing deposits and withdraws.
</h3>
<h4 align="center">
	Status:   Done 🚀 
</h4>

## 🚀 How to run
This project was built with docker containers. So to start you have to run the following command:
```bash
$ docker-compose -f docker/docker-compose.yml up
```

Then you should connect to MySQL Server using the following data and create a empty database named "jobsity":
```bash
Host: localhost:3306
User: root
Password: 
```

Following, you have to connect to thiago_php container and run migrations and seeders like below:
```bash
$ docker exec -it thiago_php /bin/bash
$ cd /var/www/api
$ php artisan migrate --seed
```

## 🦸 Author

 <img style="border-radius: 50%;" src="https://avatars2.githubusercontent.com/u/4452296?s=460&u=f7a8d771005a27cf12386ccaac301fd00ac1041a&v=4" width="100px;" alt=""/><br />
<b>Thiago Colebrusco </b>
 
## 📝 License

This project was built under [MIT](./LICENSE) license.
