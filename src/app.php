<?php
use Symfony\Component\Routing;
$routes = new Routing\RouteCollection();

if ($handle = opendir(__DIR__.'/../routes/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $twig_vars = include __DIR__.'/../routes/'.$entry;
            $routes->add(basename($entry,'.php'), new Routing\Route(basename($entry,'.php'),
    ['_controller' => 'render_template', '_twig_vars' => $twig_vars ]));
        }
    }
    closedir($handle);
}
    
    /*
    
    
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
                    'Rationale for 1: To have constructive interference at R the waves must be in phase at R. Since the extra distance travelled by one wave is a full wavelength (one full cycle) then the waves also need to be in phase at the sources to be in phase at R.',
                    'Rationale for 2: When a wave or pulse reaches a rigid barrier two things happen: it bounces back and inverts. So when half of the wave has reflected (inverted) it will superimpose with the rest of the incoming pulse (non-inverted) and cancel completely.',
                    'Rationale for 3 : Increasing the intensity means more photons. Keeping the color the same (same wavelength and frequency) means the photons have the same energy. More photons means more ejected electrons but photons with the same energy means each ejected electrons will have the same energy.',
                    'Rationale for 4: When a wave or pulse reaches a rigid barrier two things happen: it bounces back and inverts. So after the wave has completely reflected it will be moving to the left and inverted (upside down).',
                    'Rationale for 5: The difference in wavelength between any adjacent harmonic frequencies is half of a wavelength (for any air tube). The frequency is equal to wave speed over wavelength so the difference in ',
                    'Rationale for 6: The first (lowest) frequency happens when the wavelength is twice the length of the tube (displacement nodes at both ends with an anti-node in the middle) and the frequency is equal to the wave speed divided by the wavelength.',
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
        'Work function'
              ]]]
    
    )
    );
    */
return $routes;
?>
