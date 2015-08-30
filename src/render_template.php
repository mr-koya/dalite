<?php
use Symfony\Component\HttpFoundation\Session\Session;

function render_template($request)
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
$session = new Session();
$session->start();

// set and get session attributes
$question_num = $session->get('question_num', 1);

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../templates');
$twig = new Twig_Environment($loader);
$path = rtrim($request->GetPathInfo(),'/');
if($path == '')
    $path = 'index';
        
    echo $twig->render( $path . '.html.twig', [
        'alpha' => ['Z','A','B','C','D','E','F','G','H','I'],
        'question_num' => $question_num,
        'student' => ['firstname' => 'Dan', 'lastname' => 'Hill'],
        'answer' => 1,
        'question' => [[],
            [
                'title' => 'This is friction question',
                'concepts' => ['friction', 'matter'],
                'media1' => ['type' => 'image', 'data' => 'dummy-01.jpg'],
                'media2' => ['type' => 'youtube', 'data' => 'P0s1hZ-Ru-c'],
                'num_choice' => 5,
                'choice_type' => 'alpha',
                'answer' => 1,  
                'second_best' => 2,
                'correct_rationale' => 'Correct Rationale',
                
                'rationales' => ['',
                    'Rationale for a',
                    'Rationale for b',
                    'Rationale for c',
                    'Rationale for d',
                    'Rationale for e'
                    ]
                
            ],
            [
                'title' => 'This is another question',
                'concepts' => ['friction', 'tension'],
                'media1' => ['type' => 'youtube', 'data' => 'P0s1hZ-Ru-c'],
                'media2' => ['type' => 'image', 'data' => 'dummy-01.jpg'],

                'num_choice' => 6,
                'choice_type' => 'numeric',
                'answer' => 3,
                'second_best' => 1,
                'correct_rationale' => 'Here is a Correct Rationale. The ball will roll up the hill until gravity gets it down.',

                'rationales' => ['',
                    'Rationale for 1',
                    'Rationale for 2',
                    'Rationale for 3',
                    'Rationale for 4',
                    'Rationale for 5',
                    'Rationale for 6',
                    ]
              ]
          ], 
	  'concepts' => [
        'Amplitude',
        'Angular Frequency',
        'Area',
        'Conservation of Mechanical Energy',
        'Curvature',
        'Displacement',
        'Elastic Potential Energy',
        'Frequency',
        'Gravitational Potential Energy',
        'History Graph',
        'Hooke\'s Law',
        'Inertia',
        'KE of ejected electrons',
        'Kinetic Energy',
        'Mass',
        'Phase',
        'Phase Angle',
        'Propagation Velocity',
        'Restoring Constant',
        'Restoring Force',
        'Sanpshot Graph',
        'Slope',
        'Spring Constant',
        'Transverse Acceleration',
        'Transverse Velocity',
        'Velocity',
        'Wavelength',
        'Difference in energy levels',
        'Energy levels',
        'Energy of absorbed photon',
        'Energy of each photon',
        'Energy of emitted photon',
        'Excited levels',
        'Frequency of each photon',
        'Ground level',
        'Interference',
        'Number of photons',
        'Standing wave',
        'Stopping potential',
        'Traveling wave',
        'Wavelength of each photon',
        'Work function']
]);
    
 
    return new Response(ob_get_clean());
}
?>
