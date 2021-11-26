[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/badges/build.png?b=main)](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/rinnegard/mvc-proj/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://app.travis-ci.com/rinnegard/mvc-proj.svg?branch=main)](https://app.travis-ci.com/rinnegard/mvc-proj)

# Yatzy Project

This is a simple website where you can play the game [Yatzy](https://en.wikipedia.org/wiki/Yatzy).

The website was made as the final project in the course "Objektorienterade webbteknologier" also known as mvc at BTH. The project is made using [Laravel](https://laravel.com/).

## How to play
1. On the homepage you enter your username
2. Click the "Roll" button and pick which dice you want to save for the next throw
3. After you've used your 3 throws you decide which row in the scoreboard to apply them to in the dropdown box and then click the "Next Round" button and the score will be calculated and put in the correct place in the scoreboard.
4. When the scoreboard is full your final score will be calculated and added to the highscore list which you can view to see how you did. You can also search the highscore list if you want to see how a friend did.

## Install

1. Clone the [github directory](https://github.com/rinnegard/mvc-proj)..
        git clone https://github.com/rinnegard/mvc-proj.git
2. Go to your new directory and run command to install.
        make install
3. Copy the .env.example file and name it .env
4. Run command to set APP_ENV in .env
        php artisan key:generate
5. Add your own database configuration to the new .env file and then run command to set up your database
        php artisan migrate:fresh --seed

6. Run command to start your website at http://localhost:3000. You can set whatever port is free for you
        $ php artisan serve --port=3000
