#!/usr/bin/perl

use MIME::Base64;
my $username = 'travis.beste@walletsquire.com';
my $password = 'wVbz0m7c';
print encode_base64("\0$username\0$password") . "\n";
