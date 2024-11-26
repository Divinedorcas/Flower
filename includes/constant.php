<?php

const FullNameValidationPattern = "/^[a-zA-Z\s\-]+$/";
const UserNameValidationPattern = "/^[a-zA-Z0-9\-_]{3,20}$/";
const EmailValidationPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
const PhoneValidationPattern = "/^\+?[0-9]{1,4}?[-.\s]?(\(?[0-9]{1,3}?\)?[-.\s]?)?[0-9]{1,4}[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/";
const PasswordValidationPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
?>