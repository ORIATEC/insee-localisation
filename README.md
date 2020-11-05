# laravel-package-boilerplate

Boilerplate for Laravel packages. Use it as a starting point for your own Laravel packages.

## Start
Clone this package and remove .git folder

##Steps :
- Update composer.json
    * Change package name
    * Change description
    * Change keywords
    * Change authors
    * Change Namespace name in autoload.psr-4, extra.laravel.providers
- Create repository local ```git init```
- Create repository on Github
- Add remote to local repository ```git remote add origin URL_REPOSITORY```
- Develop
- Push
- Tag the release (vMajeur.mineur.hotfix)
- Push the tag release

## use the package :

- Via Github

### Without SSH Keys :

Add this in the composer.json of the project: 
```
"repositories": [
        {
            "type": "vcs",
            "url": "HTTPS_URL_OF_GITHUB_REPOSITORY"
        }
    ]
```

Create a `auth.json` file in the root directory of the projet :
```
{
    "github-oauth": {
        "github.com": "your-github-token"
    }
}
```

Require the package
```
composer require oriatec/PACKAGE_NAME
```

### With SSH Keys :

Add this in the composer.json of the project: 
```
"repositories": [
        {
            "type": "vcs",
            "url": "SSH_URL_OF_GITHUB_REPOSITORY"
        }
    ]
```

Require the package
```
composer require oriatec/PACKAGE_NAME
```

- Via local folder

Add this in the composer.json of the project: 
```
"repositories": [
        {
            "type": "vcs",
            "url": "/full/path/to/the/local/package/package-name"
        }
    ]
```

Require the package
```
composer require oriatec/PACKAGE_NAME
```

For development purpose, allow composer to use symlink by adding this on the composer.json:
```
"options": {
           "symlink": true
         }
```
