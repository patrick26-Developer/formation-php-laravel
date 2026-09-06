FROM php:8.3-cli

WORKDIR /app

COPY . /app

# ENTRYPOINT définit la commande FIXE ; tout ce qui suit "docker run ma-calculatrice"
# est passé comme arguments supplémentaires à cette commande, contrairement
# à CMD qui serait entièrement REMPLACÉ si on passait des arguments à "docker run".
ENTRYPOINT ["php", "src/cli.php"]
