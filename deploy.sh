#!/bin/bash

# Run php artisan test command
php artisan test

# Check if the command was successful
if [ $? -eq 0 ]; then
  # Push changes to GitHub
  git push --force --follow-tags

  # Clear the screen
  clear

  # Print success message
  echo "\n  \033[42;37m SUCCESS \033[0m All Tests pass. Changes pushed to GitHub.\n"
else
  # If tests failed, display error message
  echo "\n  \033[41;37m FAIL \033[0m Tests failed. Changes not pushed to GitHub.\n"
fi
