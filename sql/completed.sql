SELECT COUNT(response_) as q_completed FROM response 
where assignment_ = :assignment and student_ = :student
