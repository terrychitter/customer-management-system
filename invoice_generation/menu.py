from invoice_manager import NORMAL_BOLD, NORMAL, PROMPT, ERROR

class Menu:
    def __init__(self):
        self.options = ['Specfic accounts', 'Outstanding', 'All (exceptions)']
        self.selection = None

    def display_menu(self):
        #Displaying the menu
        print(f"\n{NORMAL_BOLD}Please select the type of generating you'd like to perform. (Select the number){NORMAL}")
        for i in range(len(self.options)):
            print(f'{NORMAL}', i+1, f".\t{self.options[i]}")

    def get_response(self):
        #Asking the user for a repsonse
        valid = False
        while not valid:
            response = input(PROMPT)

            if not response.isnumeric():
                print(f"{ERROR}This is not a valid option. Please select a number")
                continue

            if (int(response) <= 0) or (int(response) > len(self.options)+1):
                #Invalid response
                print(f"{ERROR}This number is not a valid option")
            else:
                valid = True
        return response
