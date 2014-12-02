<?php $this->assign('title', 'Hall Of Fame'); ?>
<h1>Hall Of Fame</h1>

<?php

$mlv=strval($moy['mlv']);
$mf=strval($moy['mf']);
$mvi= strval($moy['mvi']);
$mvs=strval($moy['mvs']);
$mx=strval($moy['mx']);

$countlv1=strval($moy['lv1']);
$countlv2=strval($moy['lv2']);
$countlv3=strval($moy['lv3']);
$countlv4=strval($moy['lv4']);

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
    var ticks = [";
foreach ($raw as $key => $value) {
    $name = $raw[$key]['Fighter']['name'];
    echo"
'$name',";
}
echo"];
     
    var plot1 = $.jqplot('chart1', [s1, s2, s3], {
        title: 'Caractéristiques des fighters',
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true}
        },
        animate: true,
        animateReplot: true,
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },  
        pointLabels: {
                    show: true
                },
        series:[
            {label:'Force'},
            {label:'Vision'},
            {label:'Vie'}
        ],
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: ticks
            },
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
        animate: true,
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
        animate: true,
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
