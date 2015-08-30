SELECT response.rationale, response_, assignment_, votes FROM response
where response.question_ = :question and answer = :answer and LENGTH(response.rationale) > 20
