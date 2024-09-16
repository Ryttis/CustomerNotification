# Code review task

## Task definition

* Create REST api create customer notifications by email or sms depends on customer settings.
* Customer profile data is saved in database

Request:
url: /api/customer/{code}/notifications
json: { body: "notification text"  }

# Code review

##  Make application running properly

#### 1. remove composer.lock and run composer install fix dependencies problems.
#### 2. add doctrine/doctrine-bundle and doctrine/orm for proper work of repository classes
#### 3. improved CustomerRepository
#### 4. CustomerController improved:
#### 5. dependencies CustomerRepository and Messenger injected by constructor.
#### 6. improved route annotation with /api in forward of url
#### 7. method "GET" changed into method "POST" because notification is not simple 
#### data retrieving
#### 8. added empty body empty type and customer not found checks.
#### 9. Primary key added into Customer entity

# Code review

#### 1. Directory structure:  move EntiryRepository into Repository folder
#### 2. The repository is instantiated directly inside the controller with new CustomerRepository() better is to inject it in constructor
#### 3. CustomerController is coupled with EmailSender, Messenger, SMSSender inject via constructor or service container will be better
#### 4. Change the visibility of the properties from public to private or protected for properties $code
#### and $notification_type in Customer entity
#### 5. Include @ORM\Table to specify the table name explicitly
#### 6. Into  constructor correctly inject the ManagerRegistry
#### 7. Remove not used method getEntityClass() from customerRepository
#### 8. Improve Messenger class  with error handling put in send method into try catch
