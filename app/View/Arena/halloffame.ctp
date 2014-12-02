<?php $this->assign('title', 'Hall Of Fame'); ?>
<h1>Hall Of Fame</h1>

<?php
$mforce = 0;
$mvision = 0;
$mvie = 0;
$mxp = 0;
$mlvl = 0;
$count = 0;
$countlv1 = 0;
$countlv2 = 0;
$countlv3 = 0;
$countlv4 = 0;

foreach ($raw as $key => $value) {

    $force = $raw[$key]['Fighter']['skill_strength'];
    $vision = $raw[$key]['Fighter']['skill_sight'];
    $vie = $raw[$key]['Fighter']['skill_health'];
    $xp = $raw[$key]['Fighter']['xp'];
    $lvl = $raw[$key]['Fighter']['level'];
    if ($lvl < 6) {
        $countlv1 = $countlv1 + 1;
    } else if ($lvl < 11) {
        $countlv2 = $countlv2 + 1;
    } else if ($lvl < 16) {
        $countlv3 = $countlv3 + 1;
    } else if ($lvl > 15) {
        $countlv4 = $countlv4 + 1;
    }

    $mforce = $mforce + $force;
    $mvision = $mvision + $vision;
    $mvie = $mvie + $vie;
    $mxp = $mxp + $xp;
    $mlvl = $mlvl + $lvl;
    $count = $count + 1;
}

$mf = $mforce / $count;
$mvs = $mvision / $count;
$mvi = $mvie / $count;
$mx = $mxp / $count;
$mlv = $mlvl / $count;

echo"
<div class=graph>
<div id=\"chart1\" style=\"height:400px;width:900px; \"></div>

<div id=\"chart2\" style=\"height:400px;width:900px; \"></div>

<div id=\"chart3\" style=\"height:400px;width:900px; \"></div>

<div id=\"chart4\" style=\"height:400px;width:900px; \"></div>


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
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },  
        // Custom labels for the series are specified with the \"label\"
        // option on the series option.  Here a series option object
        // is specified for each series.
        pointLabels: {
                    show: true
                },
        series:[
            {label:'Force'},
            {label:'Vision'},
            {label:'Vie'}
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
    // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
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

$(document).ready(function(){
  var data = [
    ['Niveau 1-5', $countlv1],['Niveau 6-10', $countlv2], ['Niveau 11-15', $countlv3], 
    ['Niveau 16+', $countlv4]
  ];
  var plot1 = jQuery.jqplot ('chart3', [data], 
    { 
    title: 'Répartition des Fighters selon leur niveau',
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer, 
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true
        }
      }, 
      legend: { show:true, location: 'e' }
    }
  );
});

$(document).ready(function () {
    var s1 = [";
foreach ($tab as $key => $value) {
    $jour = strval($tab[$key][0]['Jour']);
    $nb = strval($tab[$key][0]['NombreAtk']);
    echo"[$jour, $nb],";
}echo"];
    var s2 = [";
foreach ($tab2 as $key => $value) {
    $jour2 = strval($tab2[$key][0]['Jour']);
    $dep = strval($tab2[$key][0]['NombreDep']);
    echo"[$jour2, $dep],";
}echo"];
    plot1 = $.jqplot(\"chart4\", [s2, s1], {
        title: 'Nombre d\'actions par jour',
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
        series:[
            {label:'Nombre d\'attaque',
            pointLabels: {
                    show: true
                },
            renderer: $.jqplot.BarRenderer,
            showHighlight: false,
            yaxis: 'y2axis',
            rendererOptions: {
                    // Speed up the animation a little bit.
                    // This is a number of milliseconds.  
                    // Default for bar series is 3000.  
                    animation: {
                        speed: 2500
                    },
                    barWidth: 15,
                    barPadding: -15,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            },
  
            {label:'Nombre de déplacement',
            pointLabels: {
                    show: true
                },
            }
  
        ],
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axesDefaults: {
            pad: 0
        },
        axes: {
            // These options will set up the x axis like a category axis.
            
            xaxis: {
                tickInterval: 1,
                drawMajorGridlines: false,
                drawMinorGridlines: true,
                drawMajorTickMarks: false,
                rendererOptions: {
                tickInset: 0.5,
                minorTicks: 1
            }
            },
            yaxis: {
                tickOptions: {
                    formatString: \"$%'d\"
                },
                rendererOptions: {
                    forceTickAt0: true
                }
            },
            y2axis: {
                tickOptions: {
                    formatString: \"$%'d\"
                },
                rendererOptions: {
                    // align the ticks on the y2 axis with the y axis.
                    alignTicks: true,
                    forceTickAt0: true
                }
            }
        },
        highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: 'y',
            sizeAdjust: 7.5 , tooltipLocation : 'ne'
        }
    });
   
});
</script>";
?>
