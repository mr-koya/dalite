SELECT DISTINCT media1, alpha, question.rationale as rationale, response.answer as answer, response2.answer as second_answer, response.rationale as rrationale
FROM question join assignment_question on question.question_ = assignment_question.question_
    join response on question.question_ = response.question_ and response.attempt = 0
    join response as response2 on question.question_ = response2.question_ 
		and response.student_ = response2.student_
		and response.assignment_ = response2.assignment_
		and response2.attempt = 1
where response.assignment_ = :assignment and response.student_ = :student 
order by assignment_question.`order`
