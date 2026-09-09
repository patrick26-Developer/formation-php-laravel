# Commands — Exercise 4

```bash
# From the "public" folder of mini-project 02, with this Dockerfile copied at the root
docker build -t gestionnaire-taches .
docker run -p 8080:80 gestionnaire-taches
```

Open `http://localhost:8080/connexion.php`.

> Note: this container alone has no access to a MySQL database — it
> would need one, reachable over the network. That's precisely what
> Docker Compose solves in module 05.3: several containers (PHP + MySQL
> + Nginx) communicating with each other with no manual network setup.
