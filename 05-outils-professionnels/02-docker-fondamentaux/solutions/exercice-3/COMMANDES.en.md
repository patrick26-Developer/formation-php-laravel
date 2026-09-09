# Commands — Exercise 3

```bash
docker build -t ma-calculatrice .

docker run ma-calculatrice 10 + 5    # 10 + 5 = 15
docker run ma-calculatrice 20 / 4    # 20 / 4 = 5
docker run ma-calculatrice 8 / 0     # Error: Division by zero is not allowed.
```

With `CMD` (exercise 2), `docker run ma-calculatrice 20 / 4` would have
REPLACED the entire default command with "20 / 4" as-is (interpreted as
an invalid shell command), rather than appending it to `php src/cli.php`'s
arguments. `ENTRYPOINT` is the right choice whenever you want a container
to behave like an executable accepting variable arguments.
