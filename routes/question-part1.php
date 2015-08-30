<?php

$counter = 1;

function tagLabels(&$labels) {
    global $counter;
     
    foreach ($labels as &$label) {
        if(isset($label[1]) && is_array($label[1])) {
            tagLabels($label[1]);
        }
        else {
             $label = [$label, $counter]; 
             $counter++;
        }
    }
}

function build(&$a) {
    if (!array_key_exists('assignment', $a['request'])) {
        unset($a['question_num']);
        \Edu8\Http::redirect('/');
    }

    $a['alpha'] = ['Z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
    $a['from_alpha'] = ['Z' => 0, 'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9];
    $a['assignment'] = $a['request']['assignment'];
    $connection = \Edu8\Config::initDb();

    if (!array_key_exists('question_num', $a)) {
        $completed_statement = \Edu8\Sql::runStatement($connection, 'completed', ['student' => $a['student']['student_'], 'assignment' => $a['assignment']]);
        $q_completed = $completed_statement->fetchAll();

        $question_statement = \Edu8\Sql::runStatement($connection, 'assignment_question', ['assignment' => $a['assignment']]);
        $a['question'] = $question_statement->fetchAll();
        
        $question_total_statement = \Edu8\Sql::runStatement($connection, 'assignment_question_count', ['assignment' => $a['assignment']]);
        $a['question_total'] = reset($question_total_statement->fetch());
        
        /* foreach ($a['question'] as &$q) {
          $q['concepts'] = preg_split('/,/', $q['concepts']);
          } */

        $a['concepts'] = [
        ['Dynamics',
            [['What phenomena are we seeing?', 
                [['Single mass', 
                    ['On a flat surface',
                    'On inclined plane',
                    ['Moving in a circle', 
                        ['Horizontal circle',
                        'Vertical circle']]]],
                ['Multiple interacting masses',
                    [['connected by ropes & pulleys', 
                        ['Massless approximation on pulley',
                        'Non-negligible mass of pulley']],
                    'directly in contact with each other',
                    'directly in contact with each other & connected by ropes & pulleys']],
                ['Extended rigid rotating object',
                    ['About a fixed point',
                    'About a moving point ']]]], 
            ['What are the relevant variables or quantities?',
                [['Forces', 
                    [['Contact Forces', 
                        [['Friction',
                            ['Magnitude & direction of Force of Static friction depends on initial conditions of masses involved',
                            'Magnitude & direction of Force of Kinetic friction is always = ukFN, and always opposes direction of motion']],
                        ['Normal Force', 
                            ['Force exerted on an object by the surface supporting it, perpendicular to the plane of the surface',
                            'Also known as “apparent weight”',
                            'FN > mg ?',
                            'FN = mg ?',
                            'FN < mg ?']],
                        ['Tension', 
                            ['Tension force always acts along direction of the string',
                            'For massless string approximation, magnitude of tension is the same all along the length of the string']],
                        ['Drag',
                            ['Always opposite the direction of velocity']],
                        'Applied Force']],
                    ['Long Range Forces', 
                        [['Gravity', 
                            ['Always points towards the center of the earth']], 
                        'Electrostatic',
                        'Magnetic']]]],
                ['Net Force', 
                    ['Vector sum of all the forces',
                    'Directly proportional to acceleration']]]]]],
            
        ['Energy', 
            [['What are the phenomena we are seeing?', 
                [['Single mass in motion', 
                    ['Inclined plane',
                    'Vertical loop-the-loop',
                    'Irregular shaped track',
                    'Other cases']],
                ['Single mass feeling a variable force (non-constant acceleration)', 
                    ['Spring',
                    'Pendulum',
                    'Other variable force']],
                'Elastic Collision']],
            ['What are the quantities and relevant definitions and special cases?', 
                [['Kinetic energy', 
                    ['Related to object’s motion',
                    'Proportional to square of object’s speed',
                    'Proportional to object’s mass',
                    'Translational kinetic energy',
                    'Rotational kinetic energy']],
                ['Potential energy', 
                    ['Related to object’s position',
                    'Potential energy must be defined relative to a reference frame',
                    'Derivative of potential energy with respect to position equals negative of  (conservative) force',
                    ['Gravitational potential energy', 
                        ['Proportional to object’s mass and height (from reference)']],
                    ['Elastic potential energy', 
                        ['Reference position is at system’s equilibrium position']],
                    'Due to other conservative force']],
                ['Work', 
                    ['Dot product of constant force and displacement',
                    'Area under a (component) force vs. position graph (integral)',
                    'Work done by a force is positive if it is adding energy to the system'],
                    'Work done by a force is negative if it is removing energy from the system',
                    'Path independent if done by a conservative force',
                    'Depends on path if done by a non-conservative force'],
                ['Power', 
                    ['Rate at which work is done',
                    'Dot product of constant force and velocity',
                    'Area under a (component) force vs. velocity graph (integral)']]]],
            ['What are the physical laws involved?', 
                ['The work done by all external forces on an object equals the change in its kinetic energy.',
                'The work done by all non-conservative forces equals the change in the total mechanical energy of a system']]]],
            
        ['Kinematics', 
            [['What phenomena are we seeing?', 
                [['Free-fall', 
                    ['Air drag negligible ',
                    'Air drag not negligible',
                    'Near Earth’s surface',
                    'Not near Earth’s surface']],
                ['Motion on an inclined surface', 
                    ['Friction negligible',
                    'Friction not negligible',
                    'Gravity is only force pulling',
                    'Some force (other than gravity) pushing/pulling?']],
                ['Motion on a horizontal surface', 
                    ['Friction negligible',
                    'Friction is not negligible']],
                ['Motion described as a function of time', 
                    ['One dimensional',
                    'Multidimensional']],
                ['Projectile motion (in two dimensions)', 
                    ['Air friction negligible',
                    'Air friction not negligible',
                    'Something (other than gravity) pushing/pulling']],
                ['Circular motion', 
                    ['Horizontal circle',
                    ['Vertical circle', 
                        ['Gravity is only force pulling',
                        ['Something (other than gravity) pushing/pulling', 
                            ['Parallel to path',
                            'Perpendicular to path',
                            'Has components both parallel and perpendicular']]]]]]]],
            ['Important quantities, definitions and special cases', 
                [['Position', 
                    ['Equal to location of dot/point on graph or motion diagram',
                    ['Horizontal', 
                        ['Initial horizontal position is zero',
                        'Initial horizontal position of both objects are the same']],
                    ['Vertical', 
                        ['Initial vertical position is zero',
                        'Initial vertical position of both objects are the same']],
                    ['Angular', 
                        ['Initial angular position is zero',
                        'Initial angular position of both objects are the same']]]],
                ['Distance', 
                    ['Equal to sum of the displacement values']],
                ['Displacement', 
                    ['Equal to the difference in position',
                    'Equal to the area under a velocity graph']],
                ['Speed', 
                    ['Related to distance between dots on a motion diagram',
                    'Equal to steepness of position function',
                    'Speed decreases when velocity and acceleration are in opposite directions',
                    'Speed increases when velocity and acceleration are in the same direction']],
                ['Velocity', 
                    [['Horizontal', 
                        ['Initial horizontal velocity is zero',
                        'Initial horizontal velocity of both objects are the same',
                        'Initial horizontal velocity of both objects are different']],
                    ['Vertical', 
                        ['Initial vertical velocity is zero',
                        'Initial vertical velocity of both objects are the same',
                        'Initial vertical velocity of both objects are different']],
                    ['Angular', 
                        ['Initial angular velocity is zero',
                        'Initial angular velocity of both objects are the same',
                        'Initial angular velocity of both objects are different']],
                    ['Average (1D only)', 
                        ['Equal to displacement/time interval',
                        'Related to distance between dots on a motion diagram']],
                    ['Instantaneous', 
                        ['Equal to slope of position graph',
                        'Equal to derivative of position function',
                        'Constant',
                        'Not constant']]]],
                ['Acceleration', 
                    [['Average (1D only)', 
                        ['Equal to change in velocity/time interval',
                        'Related to the change in distance between dots on a motion diagram']],
                    ['Instantaneous', 
                        ['Equal to derivative of velocity function',
                        'Equal to slope of velocity graph',
                        'Equal to curvature of position function']],
                    ['Object is slowing', 
                        ['Direction of acceleration and velocity are opposite']],
                    ['Object is speeding up', 
                        ['Direction of acceleration and velocity are parallel']],
                    ['Constant', 
                        ['has magnitude = g',
                        'has magnitude = 0',
                        'has magnitude = g sinθ',
                        'has magnitude = v2/R']],
                    'Constant during intervals but changes suddenly in-between',
                    'Not constant']]]]]],
            
        ['Momentum', 
            [['Phenomena and cases', 
                [['Collisions', 
                    ['Elastic',
                    'Inelastic',
                    'Perfectly inelastic']],
                'Explosions',
                'Single mass begin hit/pulled by a force',
                ['Multiple Masses Pushing/Pulling Each Other', 
                    ['Horizontal Fnet=0',
                    'Vertical Fnet=0',
                    'All directions Fnet=0']]]],
            ['Important quantities, definitions and special cases', 
                [['Mass', 
                    ['mass before = mass after',
                    'mass before≠ mass after']],
                ['Velocity', 
                    ['Must be treated as a vector (components)',
                    'velocity before = velocity after',
                    'velocity before≠velocity after']],
                ['Momentum', 
                    ['Must be treated as a vector (components)',
                    'Is in the same direction as velocity',
                    'momentum before = momentum after',
                    'momentum before≠momentum after']],
                ['Time interval', 
                    ['If time interval of interaction is very short then Δp≈0',
                    'If time interval of interaction is not short then Δp≠0']],
                ['Impulse', 
                    ['Equal to the change in momentum',
                    'Area under a force vs. time graph (integral)']]]],
            ['Laws', 
                ['If net external force on the system is zero then the system’s momentum is the same before and after.',
                'The rate of change of momentum is equal to the net external force acting on an object.']]]]
        ];

        $a['question_num'] = $q_completed[0]['q_completed'] >> 1;   // div by 2 | note: >> will have no effect if 0.

        if (count($a['question']) <= $a['question_num']) {
            \Edu8\Http::redirect('/question-review');
        }
        
        tagLabels( $a['concepts']);
    }    
}

?>
