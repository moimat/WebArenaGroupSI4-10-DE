<?php $this->assign('title', 'Hall Of Fame'); ?>
<h1>Hall Of Fame</h1>

<h2>Fighter Abilities</h2>
<?php

$mforce=0;
$mvision=0;
$mvie=0;
$mxp=0;
$mlvl=0;
$count=0;

foreach ($raw as $key => $value) {
    
    $force = $raw[$key]['Fighter']['skill_strength'];
    $vision = $raw[$key]['Fighter']['skill_sight'];
    $vie = $raw[$key]['Fighter']['skill_health'];
    $xp = $raw[$key]['Fighter']['xp'];
    $lvl = $raw[$key]['Fighter']['level'];
    
    $mforce=$mforce+$force;
    $mvision=$mvision+$vision;
    $mvie=$mvie+$vie;
    $mxp=$mxp+$xp;
    $mlvl=$mlvl+$lvl;
    $count=$count+1;
}

$mf=$mforce/$count;
$mvs=$mvision/$count;
$mvi=$mvie/$count;
$mx=$mxp/$count;
$mlv=$mlvl/$count;

echo "$mf $mvs $mvi $mx $mlv";

echo"
<div>
<div id=\"chart1\" style=\"height:400px;width:900px; \"></div>

<div id=\"chart2\" style=\"height:400px;width:900px; \"></div>

<p><br><br><br></p>

<style type=\"text/css\">
#chart2 .jqplot-point-label {
  border: 1.5px solid #aaaaaa;
  padding: 1px 3px;
  background-color: #eeccdd;
}
</style>

<script>
$(document).ready(function(){
    var s1 = [";

foreach ($raw as $key => $value) {
    $sst = $raw[$key]['Fighter']['skill_strength'];
    echo"
$sst,";
}
echo"];
    var s2 = [";
foreach ($raw as $key => $value) {
    $ssi = $raw[$key]['Fighter']['skill_sight'];
    echo"
$ssi,";
}
echo"];
    var s3 = [";
foreach ($raw as $key => $value) {
    $sh = $raw[$key]['Fighter']['skill_health'];
    echo"
$sh,";
}
echo"];
    
    // Can specify a custom tick Array.
    // Ticks should match up one for each y value (category) in the series.
    
    var ticks = [";
foreach ($raw as $key => $value) {
    $name = $raw[$key]['Fighter']['name'];
    echo"
'$name',";
    }
echo"];
     
    var plot1 = $.jqplot('chart1', [s1, s2, s3], {
        title: 'Caractéristiques des fighters',
        // The \"seriesDefaults\" option is an options object that will
        // be applied to all series in the chart.
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true}
        },
        // Custom labels for the series are specified with the \"label\"
        // option on the series option.  Here a series option object
        // is specified for each series.
        series:[
            {label:'Strength'},
            {label:'Sight'},
            {label:'Health'}
        ],
        // Show the legend and put it outside the grid, but inside the
        // plot container, shrinking the grid to accomodate the legend.
        // A value of \"outside\" would not shrink the grid and allow
        // the legend to overflow the container.
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
            // Use a category axis on the x axis and use our custom ticks.
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
            // Pad the y axis just a little so bars can get close to, but
            // not touch, the grid boundaries.  1.2 is the default padding.
            yaxis: {
                pad: 1.05,
                tickOptions: {formatString: '$%d'}
            }
        }
    });
});

$(document).ready(function(){
  var line1 = [$mlv, $mf, $mvi, $mvs, $mx];
  var plot3 = $.jqplot('chart2', [line1], {
    title: 'Moyenne des caractéristiques de tous les fighters', 
    seriesDefaults: {renderer: $.jqplot.BarRenderer},
    series:[
     {pointLabels:{
        show: true,
        labels:['Niveau', 'Force', 'Vie', 'Vue', 'Experience']
      }}],
    axes: {
      xaxis:{renderer:$.jqplot.CategoryAxisRenderer},
      yaxis:{padMax:1.3}}
  });
});
</script>";
?>
