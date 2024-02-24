<?php

if(Sessions::isAuthenticated()) {
    Sessions::load_template('mod_scripts/post');
}  else {
    Sessions::load_template('mod_scripts/CTA');
}


