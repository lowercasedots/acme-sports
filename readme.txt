I started this project out by making a simple table with headers and outputting the data in a very basic form just to see what I had to work with. Given we just had json data and no image assets, I opted to stick with this initial table method and focus on ease of information (sort of like a wikipedia table) rather than a "prettier" but less easy-to-parse method.

Continuing that wiki table influence, I realized that the best way to sort the data would be to click on the headers to sort in ascending/descending order. I hadn't coded something like that before, so that solidified my decision to keep the table method and move forward with the sort functionality. I added some arrows for each column to also demonstrate to a reader that the headers are clickable/sortable. In a theoretical version 2 of this feature, I'd like to have the initial state of the arrows to show both a smaller up *and* down arrow, then on click, showing only up or down (depending on sort direction). On clicking on a different header, the other two arrows should then revert to the initial 'unsorted' up/down arrow state.



I mentioned debating other methods of displaying the data, and another potential could have been a sort of "hockey card" type display, although to give that method justice I would have wanted to have assets such as a team logo, or even the predominant colors used by the team. This would have given far more opportunity to display some fancy front-end features, like having the cards slide into position, or having them 'flip' to show additional information on the back.

Along the same lines, I didn't find much of an opportunity to use display: flex; for this project, which is odd as I've used it (and grid) *very* frequently in previous site builds. Because the output is a table, it seemed to work quite well responsively as-is. As such, I only included some very rudimentary responsive breakpoints, like making the text smaller. Normally, I'd use SCSS mixins for the breakpoints, but it felt like a lot of additional code to include given that I only wrote out two or three responsive lines. The card method above would also have been a perfect opportunity for flexbox/responsiveness, as each breakpoint could show a different number of cards per row/column.



Another improvement could be made to how I'm handling the error messages. Rather than returning a line of HTML, I could create a function to handle the returning of the static parts of the error. Something like:

function show_error($message) {
  return '<div class="nfl-teams error"><small>(This error message is only viewable by admins.)</small><br>' . $message . '</div>';
}

Errors could then be returned by calling that function:
return show_error('Error text goes here!');

This would be more "future proof" in the event that more errors or warnings are needed.

Additionally, properly escaping the database calls and sanitizing user inputs was not done. As this is a code example, we can be sure that the plugin won't be used for malicious intent - but as the inputs aren't sanitized, they could theoretically be used to enter a JS script, or some other method of executing remote code. 