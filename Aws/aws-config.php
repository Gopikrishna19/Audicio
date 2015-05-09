<?php
    return array(
        'includes' => array('_aws'),
        'services' => array(
            'default_settings' => array(
                'params' => array(
                    'credentials' => array(
                        'key' => AWS_KEY,
                        'secret' => AWS_SECRET
                    ),
                    'region' => 'us-west-2'
                )
            )
        )
    );
?>