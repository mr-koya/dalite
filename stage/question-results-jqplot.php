<?php
//select * from assignment;
//
//select question, count(student) from answer where assignment=450 group by question;
//
//select question.id, question.description from question, assignment where question.id = assignment_question.question and assignment_question.assignment=451 order by assignment_question.ord asc
//
//// number of students that have a question for individual assignment
//select count(id) as count from grp member where grp =  and assignment = 450;
//
//// number of students that have a question for group assignment
//SELECT count( DISTINCT grp ) FROM grp_member WHERE assignment =451
error_reporting(E_ERROR);
require_once './header.php';

//if (!$_SESSION['sid']){
//  header("Location:/src/php/pages/");
//}
require_once '../db.class.php';
$db = new db_class();
 // query for assignment list
$aid = 0; //assignment id
$ass = $db->select("select * from assignment");

if(isset($_REQUEST['id']) && isset($_REQUEST['is_group'])){
    $aid = $_REQUEST['id'];
    
    // get range depending on if group or not
    if ($_REQUEST['is_group'] == 0)
    {
        $q = $db->select('select count(id) as count from grp_member where assignment ='.$aid);
    }else{
        $q = $db->select('SELECT count( DISTINCT grp ) as count FROM grp_member WHERE assignment='.$aid);
    }
    $r = $db->get_row($q);
    $range = $r['count'];// we have range for the graph
    // now get questions in assignment
    //$db->print_last_error();
    
    $questions = $db->select('select question.id, question.description from question, assignment_question where question.id = assignment_question.question and assignment_question.assignment='.$aid.' order by assignment_question.ord asc');
    $jsquestions = array();
    while($r = $db->get_row($questions)){
        $jsquestions[$r['id']] = $r['id'].'-'.$r['description'];
    }
    
}

?>
<script language="javascript" type="text/javascript" src="/src/js/jquery.jqplot.min.js"></script>
<!--<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.canvasTextRenderer.js"></script>
<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.canvasAxisLabelRenderer.js"></script>
<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.canvasAxisTickRenderer.js"></script>
<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.categoryAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.pointLabels.js"></script>-->
<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.barRenderer.js"></script>
<script language="javascript" type="text/javascript" src="/src/js/plugins/jqplot.categoryAxisRenderer.js"></script>
<link rel="stylesheet" type="text/css" href="/src/css/jquery.jqplot.css" />
<script> 
<?php if($aid != 0){// only output this section if ther is graph data
    echo 'var range = '.$range.";\n";
    echo 'var questions = '.  json_encode($jsquestions).";"
    ?> 
    //alert(questions[400]);
    var plotoptions = 
            {
            seriesDefaults:{
                    renderer:$.jqplot.BarRenderer,
                    shadowAngle: 135,
                    rendererOptions:{varyBarColor: true, barDirection:'horizontal'},
                    pointLabels: { show:true, ypadding:0 }
                    
                },
                //seriesColors:['#eee','#222','#aaa'],
            axes: {
                xaxis:{
                    max:36,
                    min:0,
                    //tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    //autoscale:true,
                    tickOptions: {
                         formatString:'%.0f'
                    //    enableFontSupport: true,
                     //   showLabel: false,
                        //formatString:'%.2f'
                    }                   
                },
                yaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    //ticks:questions
                    //label:"blah",
                    //tickInterval: 5,
                    
                    //min:0
                    //tickOptions:{
                       
                    //}
                }
            }
        };
        //$(document).ready(init_graph('450','0'));
        //alert(plotoptions.axes.yaxis.ticks);
        
        //assignment_graph = $.jqplot('chart',[2,2,2],plotoptions);
        
        
        
 <?php }; ?>   
    
    
    
    
    function init_graph(aid,is_group){
        $.jqplot('chart2',questions, plotoptions);
    }
    
    
    
</script>

<div id="container2">

<div id="middle-top">
	
</div>

<div id="middle-center">
    
    <div id="assignment-list" style="width:200">
        <?php
            while($r=$db->get_row($ass)){
                echo '<a href="?id='.$r['id'].'&is_group='.$r['is_group'].'">'.$r['name'].'</a><br>';
            }
        ?>
    </div>
    <div id="chart2" class="chart" style="height:200px;width:400px;position:relative;right:-300px;"></div>
    
</div><!-- id="middle-center"> -->	

<div id="middle-bottom"></div>
 
</div>
<label><input type='hidden' id='counter' name='counter' value=""/></label>
<script>$(document).ready(init_graph('450','0'));//this has to stay way down here</script>
<?php require_once './footer.php'; ?>
select * from question, grp_member, student, assignment_question where question.id=assignment_question and grp_member.assignment=assignment.id order by student.id, assignment.ord