# Solution — Exercise 1

```bash
docker run php:8.3-cli php -v
```
Displays the PHP version, then the container exits immediately
(the `php -v` command runs and returns control).

```bash
docker run -it php:8.3-cli php -a
```
`-it` (interactive + pseudo-terminal) keeps the container open and
connected to your terminal: `php -a` launches PHP's interactive mode
(a REPL), where you can type PHP code line by line and see the result
immediately. Type `exit` or `Ctrl+D` to quit and stop the container.

Key difference: without `-it`, a container runs its command then stops
as soon as it finishes — no interaction possible.
