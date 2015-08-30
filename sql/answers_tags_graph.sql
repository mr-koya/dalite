select answer, concepts
from response 
where question_ = :question_ and attempt = 1
