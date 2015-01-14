#!/bin/sh

usage()
{
    echo "Type: [dep.sh -i] to clear cache and logs, set proper permisions, self-update composer and update symfony"
    echo "Type: [dep.sh -c] to clear cache, run assetic and copy needed files"
    echo "Type: [dep.sh -h] to display this help"
}

if [ "$#" = "0" ]
then
    echo "BRAK"
    # usage
    exit
fi

while getopts ich option
do
    case "${option}"
    in
        i)
            echo "Running fresh install"
            HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx|webdev' | grep -v root | head -1 | cut -d\  -f1`
            sudo setfacl -Rn -m m::rwX -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
            sudo setfacl -dRn -m m::rwX -m u:"$HTTPDUSER":rwX -m u:`whoami`:rwX app/cache app/logs
            echo "Done"
            ;;
        c)
            echo "Clearing cache"
            php app/console cache:clear --env=prod
            php app/console cache:clear --env=dev
            php app/console assets:install
            php app/console assetic:dump --env=prod
            php app/console assetic:dump --env=dev
            cp -rf ./vendor/twitter/bootstrap/dist/fonts ./web/twitter/bootstrap/dist/fonts
            cp -rf ./vendor/components/jqueryui/themes/smoothness/images ./web/components/jqueryui/themes/smoothness/images
            chmod -R 777 app/cache/
            chmod -R 777 app/logs/
            echo "Done"
            ;;
        h)
            usage
            ;;
        ?)
            usage
            ;;
    esac
done
