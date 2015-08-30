select count(response_) as count, answer 
from response 
where question_ = :question_ and attempt = 1
group by answer;