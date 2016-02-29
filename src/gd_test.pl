#!/usr/bin/perl 
use strict;
use Jcode;

use GD::Graph::bars;
 
my @labels  = qw( under 10s  20s  30s  40s  50s  60s  70s over );
my @dataset = qw(   20   40   60   80   65   15   10   20    5 );
my @data    = ( \@labels, \@dataset);
 
my $graph = GD::Graph::bars->new( 400, 300 );
 
$graph->set( title   => jcode("人口")->utf8,
             y_label => jcode("人数")->utf8 );
 
GD::Text->font_path( "C:/WINDOWS/FONTS" );
$graph->set_title_font( 'MSGOTHIC.ttc', 18 );
$graph->set_y_label_font('MSGOTHIC.ttc',18); 

my $image = $graph->plot( \@data );
 
open( OUT, "> graph.jpg") or die( "Cannot open file: graph.jpg" );
binmode OUT;
print OUT $image->jpeg();
close OUT;

print STDOUT "Content-type:text/html\n\n";
print STDOUT << "END_OF_HTML";
 
<html>
<body>
<img src="graph.jpg">
</body>
</html>

END_OF_HTML
