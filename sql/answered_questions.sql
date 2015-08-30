select response.question_, assignment.name, assignment_question.order, count(response.response_) as num_responses
from response, assignment_question, assignment
where response.question_ = assignment_question.question_ and assignment_question.assignment_ = assignment.assignment_
and response.attempt = 1
group by response.question_
order by assignment.name, assignment_question.order;