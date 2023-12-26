<?php

if(Sessions::isAuthenticated()) {
    Sessions::load_template('mod_scripts/upload');
}  else {
    Sessions::load_template('mod_scripts/CTA');
}

Sessions::load_template('mod_scripts/post');
