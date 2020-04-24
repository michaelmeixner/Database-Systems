<!--
    need tables of:
        Students:
            studentID - key attribute
            name
            SSN
            current address
            permanent address
            bdate
            sex
            class rank
        ParentPhone:
            studentID - key attribute
            phone - key attribute
        Major:
            studentID - key attribute
            deptID - key attribute
            grad semester
            grad year
        Minor:
            studentID - key attribute
            deptID - key attribute
        Dept:
            deptID - key attribute
            code
            name
            college
            coolness
        Dept Chair:
            deptID - key attribute
            employeeID - key attribute
            startDate
            endDate
        Course:
            courseID - key attribute
            name
            description
            course number
            credit hours
            level
            deptID
            start date
            end date
            type (as in lecture or lab)
        Section:
            sectionID - key attribute
            semester
            year
            courseID
            section name
        Section Instructor:
            sectionID - k.a.
            employeeID - k.a.
        Enrollment:
            studentID - ka
            sectionID - ka
            grade
        Employee:
            employeeID - ka
            name
now write sql to make these tables (shown below)
-->

CREATE TABLE students (
    studentID int not null auto_increment,
    studentName varchar(256) not null,
    ssn char(9) not null, (string, not an int because it might have a 0 at the beginning)
    currentAddress varchar(256) not null,
    permanentAddress varchar(512) not null,
    birthdate date not null,
    sex boolean not null,
    classRank int not null,
    primary key(studentID)
);