SELECT * FROM question natural join assignment_question
where assignment_ = :assignment
order by assignment_question.`order`
