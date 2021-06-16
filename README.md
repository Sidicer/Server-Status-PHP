
# Server/Raspberry Status (HTML/PHP)

Dependencies (if you have LEMP stack already running)
```bash
sudo apt install screenfetch lm-sensors aha
```
![image](https://user-images.githubusercontent.com/9251667/122269712-2e542b00-cee6-11eb-9683-539cde3972e0.png)

Edit `connection.php` with your MySQL credentials. If the connection succeeds you will see "mysql is connected".

---
TL;DR: shell_exec() wrapped with Bootstrap.

`connection.php` tries to connect to MySQL database with given credentials, if it fails - it returns `false` which is then used in `index.php` as a check to output either "connected" or "disconnected".

cpu temp is taken from `ln-sensors` package and put into an array. The `readsensors.php` was written by [divinity76](https://github.com/divinity76) for this question on [StackOverflow](https://stackoverflow.com/users/1067003/hanshenrik).
I just took the output of his function with `$read_sensors[0]['temp1']['input']` and colored it by checking if the temperature is above or below 50°C

Everything arround is just another `shell_exec()` which takes "screenfetch" and puts it through `aha` package which takes VT100 coding and and stouts HTML (without `<head>` tags) by using `screenfetch | aha -n`
