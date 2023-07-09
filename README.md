# StudyFly
### StudyFly is a question-answer platform
built using Laravel in the back-end, along with Inertia.js, Vue.js and Tailwind CSS in the front-end.

# It: 
- uses Imgur API to store images.
- stores other types of files in the server itself, but it can be easily changed ( by implementing a S3 file storage, for example )
- provides Markdown language support for writing questions
- supports math formula insertion in questions and answers, using LaTeX markup language
- has email confirmation and password reset features using tokens sent through e-mail


<span>*</span> It`s not finished yet, but the main features are implemented.

#

## Usage
### Requirements
* node.js
* pnpm
* php
* composer

In order to run the application: 
1. ```$ composer install```
2. Create ( and fill ) your .env file based on .env.example.
3. If you don`t have a previously created APP_KEY, run ```php artisan key:generate```
4. ```$ pnpm install && pnpm run build```
5. And finally: ```$ docker compose up```

If you`are just testing and do not have a configured database, use ```docker compose -f docker-compose-dev.yml up```. It will create a database container. Use this only in testing. 



