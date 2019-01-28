#!/usr/bin/perl
#
# Written by Travis Kent Beste
# Sun May 27 09:36:26 CDT 2018

use strict;
use warnings;

my $directory = $ARGV[0];
my $table     = $ARGV[1];
my $prevprev  = '';
my $prev      = '';

open(FP, $directory . '/' . $table . '.php');
while(<FP>) {
	chomp();
	if ( ($prevprev eq '') && ($prev eq '') && ($_ eq '') ) {
		print "    /**\n";
		print "     * Set id.\n";
		print "     *\n";
		print "     * \@param string|null \$id\n";
		print "     *\n";
		print "     * \@return $table\n";
		print "     */\n";
		print "    public function setId(\$id = null)\n";
		print "    {\n";
		print "    \t\$this->id = \$id;\n";
		print "    \n";
		print "    \treturn \$this;\n";
		print "    }\n\n";
	} else {
		print "$_\n";
	}
	$prevprev = $prev;
	$prev = $_;
}
close(FP);

exit(0);
