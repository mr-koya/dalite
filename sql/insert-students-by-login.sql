INSERT INTO student_course (student_, course_)
SELECT student_, ? FROM student where login in (?)