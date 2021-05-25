<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'source' => [
        'title' => 'Sources',

        'actions' => [
            'index' => 'Sources',
            'create' => 'New Source',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'creator_id' => 'Creator',
            
        ],
    ],

    'player' => [
        'title' => 'Players',

        'actions' => [
            'index' => 'Players',
            'create' => 'New Player',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'middle_name' => 'Middle name',
            'last_name' => 'Last name',
            'preferred_name' => 'Preferred name',
            'date_of_birth' => 'Date of birth',
            
        ],
    ],

    'position' => [
        'title' => 'Positions',

        'actions' => [
            'index' => 'Positions',
            'create' => 'New Position',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description'
            
        ],
    ],

    'classification' => [
        'title' => 'Classifications',

        'actions' => [
            'index' => 'Classifications',
            'create' => 'New Classification',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description'
            
        ],
    ],

    'ranking-instance' => [
        'title' => 'Ranking Instances',

        'actions' => [
            'index' => 'Ranking Instances',
            'create' => 'New Ranking Instance',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'description' => 'Description',
            'source_id' => 'Source',
            'season' => 'Season',
            'date' => 'Date',
            
        ],
    ],

    'hand-type' => [
        'title' => 'Hand Types',

        'actions' => [
            'index' => 'Hand Types',
            'create' => 'New Hand Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'seasonal-player' => [
        'title' => 'Seasonal Player',

        'actions' => [
            'index' => 'Seasonal Player',
            'create' => 'New Seasonal Player',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'player_id' => 'Player',
            'season' => 'Season',
            'school' => 'School',
            'city' => 'City',
            'state' => 'State',
            'classification_id' => 'Classification',
            'commitment' => 'Commitment',
            'height' => 'Height',
            'weight' => 'Weight',
            'bats' => 'Bats',
            'throws' => 'Throws',
            
        ],
    ],

    'ranking' => [
        'title' => 'Rankings',

        'actions' => [
            'index' => 'Rankings',
            'create' => 'New Ranking',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'seasonal_player_id' => 'Seasonal player',
            'ranking_instance_id' => 'Ranking instance',
            'rank' => 'Rank',
            
        ],
    ],

    'seasonal-player-position' => [
        'title' => 'Seasonal Player Positions',

        'actions' => [
            'index' => 'Seasonal Player Positions',
            'create' => 'New Seasonal Player Position',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'seasonal_player_id' => 'Seasonal player',
            'position_id' => 'Position',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];