# Shopping Cart Package

My attempt at building my application logic as a package. I needed to bring in the `darryldecode/laravelshoppingcart` package to provide my users with a cart, but I wanted to keep from coupling my code to the package as much as possible. I wrote an adapter that adheres to an interface I use to resolve the instance throughout my app. I also set up two cart instances, one storing to the use's session while the other persists to the database.
