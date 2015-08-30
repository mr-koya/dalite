Select firstname, lastname, student.student_, `order`, response.answer as r_answer, response.second_answer as r_second_answer, response.rationale as s_rationale,
response.answer = question.answer as correct, response.second_answer = question.answer as second_correct from response 
join student on student.student_ = response.student_
join assignment_question on assignment_question.assignment_ = response.assignment_ and assignment_question.question_ = response.question_
join question on question.question_ = response.question_
WHERE response.assignment_ = :assignment 
ORDER BY student.lastname, response.student_, assignment_question.`order`