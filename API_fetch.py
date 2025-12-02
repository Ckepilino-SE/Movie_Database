import requests
import csv
import time
import urllib.parse
from datetime import datetime

API_KEY = 'fa86c92f'
DELAY = 1.1
BASE_URL = "http://www.omdbapi.com/"

TOP_250_MOVIES = [
    "The Shawshank Redemption", "The Godfather", "The Dark Knight", "The Godfather Part II", "12 Angry Men",
    "Schindler's List", "The Lord of the Rings: The Return of the King", "Pulp Fiction", "The Lord of the Rings: The Fellowship of the Ring",
    "Forrest Gump", "Inception", "The Lord of the Rings: The Two Towers", "Fight Club", "The Empire Strikes Back",
    "The Matrix", "Goodfellas", "One Flew Over the Cuckoo's Nest", "Se7en", "Interstellar", "It's a Wonderful Life",
    "The Silence of the Lambs", "Saving Private Ryan", "City of God", "Life Is Beautiful", "The Green Mile",
    "Star Wars", "Terminator 2: Judgment Day", "Back to the Future", "Spirited Away", "The Pianist",
    "Psycho", "Whiplash", "The Lion King", "Gladiator", "American History X", "The Departed", "The Usual Suspects",
    "The Prestige", "Grave of the Fireflies", "Casablanca", "Harrier", "Modern Times", "Once Upon a Time in America",
    "Rear Window", "Alien", "City Lights", "Cinema Paradiso", "Memento", "Apocalypse Now", "Indiana Jones and the Raiders of the Lost Ark",
    "Django Unchained", "WALL·E", "The Lives of Others", "Sunset Blvd.", "Paths of Glory", "The Shining", "The Great Dictator",
    "Witness for the Prosecution", "Aliens", "American Beauty", "The Dark Knight Rises", "Dr. Strangelove", "Toy Story 3",
    "Princess Mononoke", "Braveheart", "Amélie", "Toy Story", "Reservoir Dogs", "Your Name.", "Requiem for a Dream",
    "Das Boot", "Star Wars: Episode VI - Return of the Jedi", "Oldboy", "Singin' in the Rain", "Coco", "Bicycle Thieves",
    "2001: A Space Odyssey", "The Sixth Sense", "The Kid", "Inglourious Basterds", "The Hunt", "The Intouchables",
    "Batman Begins", "A Clockwork Orange", "Snatch", "Amadeus", "Three Billboards Outside Ebbing, Missouri", "Star Wars: Episode V - The Empire Strikes Back",
    "Eternal Sunshine of the Spotless Mind", "Whiplash", "The Wolf of Wall Street", "The Treasure of the Sierra Madre", "North by Northwest",
    "V for Vendetta", "Raiders of the Lost Ark", "The Secret Window", "The Thing", "Scarface", "No Country for Old Men",
    "Jaws", "Raging Bull", "Lock, Stock and Two Smoking Barrels", "Fargo", "The Elephant Man", "The Sting", "The Apartment",
    "The Iron Giant", "Good Will Hunting", "Die Hard", "Indiana Jones and the Last Crusade", "The General", "The Grand Budapest Hotel",
    "The Deer Hunter", "The Third Man", "The Incredibles", "The Exorcist", "Warrior", "Trainspotting", "Vikings: Valhalla",
    "Children of Men", "The Princess Bride", "The Terminator", "The Graduate", "Inside Out", "The Gold Rush", "The Man Who Shot Liberty Valance",
    "The Wizard of Oz", "The Hangover", "On the Waterfront", "Cool Hand Luke", "The Passion of Joan of Arc", "Up", "The Prestige",
    "The 400 Blows", "Heat", "Double Indemnity", "The Wild Bunch", "The Battle of Algiers", "The Wages of Fear", "The Exorcist",
    "L.A. Confidential", "The Bridge on the River Kwai", "Dog Day Afternoon", "The Night of the Hunter", "The Day the Earth Stood Still",
    "The Best Years of Our Lives", "The Grapes of Wrath", "The Manchurian Candidate", "The Killing", "In the Name of the Father",
    "The Straight Story", "Butch Cassidy and the Sundance Kid", "The French Connection", "The King of Comedy", "The Conversation",
    "All About Eve", "The Maltese Falcon", "The Lady Eve", "Sullivan's Travels", "The Shop Around the Corner", "High Noon",
    "The Searchers", "Rio Bravo", "The Alamo", "Spartacus", "Lawrence of Arabia", "Doctor Zhivago", "The Sound of Music",
    "West Side Story", "My Fair Lady", "Mary Poppins", "The Music Man", "The Longest Day", "How the West Was Won", "The Great Escape",
    "To Kill a Mockingbird", "The Birds", "Marnie", "Frenzy", "Family Plot", "Vertigo", "Psycho", "North by Northwest",
    "Rebel Without a Cause", "East of Eden", "Giant", "A Place in the Sun", "Sunset Boulevard", "All About Eve", "The Asphalt Jungle",
    "White Heat", "The Set-Up", "Force of Evil", "Brute Force", "The Naked City", "Call Northside 777", "Boomerang!", "The Big Heat",
    "On Dangerous Ground", "Pickup on South Street", "Nightfall", "The Narrow Margin", "Crime Wave", "The Big Combo", "Kiss Me Deadly",
    "The Killing", "Touch of Evil", "Sweet Smell of Success", "The Wrong Man", "Anatomy of a Murder", "In Cold Blood", "Bullitt",
    "Dirty Harry", "The French Connection", "Serpico", "Dog Day Afternoon", "Prince of the City", "The Untouchables", "L.A. Confidential",
    "Heat", "The Departed", "Zodiac", "Gone Girl", "Prisoners", "The Girl with the Dragon Tattoo", "Mystic River", "The Town",
    "Shutter Island", "The Prestige", "Memento", "Insomnia", "Batman Begins", "The Dark Knight", "The Dark Knight Rises",
    "Inception", "Interstellar", "Dunkirk", "Tenet", "Oppenheimer", "The Revenant", "Birdman or (The Unexpected Virtue of Ignorance)",
    "The Grand Budapest Hotel", "Moonlight", "La La Land", "Manchester by the Sea", "Call Me by Your Name", "Lady Bird",
    "Three Billboards Outside Ebbing, Missouri", "Phantom Thread", "The Shape of Water", "Roma", "Green Book", "Parasite",
    "Nomadland", "Minari", "Promising Young Woman", "The Trial of the Chicago 7", "Sound of Metal", "Judas and the Black Messiah",
    "CODA", "Belfast", "Drive My Car", "Licorice Pizza", "The Power of the Dog", "Everything Everywhere All at Once",
    "Tár", "The Banshees of Inisherin", "The Fabelmans", "Women Talking", "Triangle of Sadness", "Aftersun", "The Whale",
    "The Holdovers", "Anatomy of a Fall", "Poor Things", "American Fiction", "The Zone of Interest", "Past Lives", "Killers of the Flower Moon",
    "Barbie", "Oppenheimer", "Dune: Part Two", "Challengers", "Furiosa: A Mad Max Saga", "The Fall Guy", "Deadpool & Wolverine",
    "Inside Out 2", "Despicable Me 4", "It Ends with Us", "Twisters", "A Quiet Place: Day One", "Kingdom of the Planet of the Apes",
    "Bad Boys: Ride or Die", "The Garfield Movie", "Ghostbusters: Frozen Empire", "Argylle", "Madame Web", "Bob Marley: One Love",
    "The Chosen: Last Supper", "IF", "The Fall Guy", "Mean Girls", "The Ministry of Ungentlemanly Warfare", "Challengers"
]

movies = []
people = {}
directs = []
writes = []
stars_in = []

print("Fetching Top 250 IMDb movies...\n")

for idx, title in enumerate(TOP_250_MOVIES[:250], 1):
    print(f"[{idx:3}/250] {title[:40]:40}...", end="")
    params = {"apikey": API_KEY, "t": title}
    try:
        resp = requests.get(BASE_URL, params=params, timeout=10)
        # raise for HTTP errors so we can surface them
        resp.raise_for_status()
        data = resp.json()
        if data.get("Response") == "False":
            print(f" Not found ({data.get('Error')})")
            continue

        # MOVIE
        release_date = f"{data['Year']}-01-01"
        genre = data["Genre"].split(", ")[0] if data["Genre"] != "N/A" else "Unknown"
        runtime = int(data["Runtime"].split()[0]) if data["Runtime"] != "N/A" else None

        movies.append({
            "Title": data["Title"],
            "ReleaseDate": release_date,
            "Genre": genre,
            "MPAARating": data.get("Rated", "NR"),
            "Poster": data["Poster"] if data["Poster"] != "N/A" else None,
            "Runtime": runtime
        })

        def fake_dob(name):
            # Generates repeatable fake birthdays based on a name
            base = 1950
            year = base + (sum(ord(c) for c in name) % 50)  # 1950–2000
            month = (sum(ord(c) for c in name[:2]) % 12) + 1
            day = (sum(ord(c) for c in name[-2:]) % 28) + 1
            return f"{year:04d}-{month:02d}-{day:02d}"

        # PERSON + ROLES
        def add_person(name_str, role_table):
            if not name_str or name_str == "N/A": return
            names = [n.strip() for n in name_str.split(",")][:3]
            for name in names:
                parts = name.split()
                if len(parts) < 2: continue
                first, last = parts[0], " ".join(parts[1:])
                dob = fake_dob(name)
                key = (first, last, dob)
                if key not in people:
                    people[key] = key
                if role_table == "DIRECTS":
                    directs.append([data["Title"], release_date, first, last, dob])
                elif role_table == "WRITES":
                    writes.append([data["Title"], release_date, first, last, dob])
                elif role_table == "STARS_IN":
                    stars_in.append([data["Title"], release_date, first, last, dob])

        add_person(data.get("Director"), "DIRECTS")
        add_person(data.get("Writer"), "WRITES")
        add_person(data.get("Actors"), "STARS_IN")

        print(" OK")
        time.sleep(DELAY)
    except Exception as e:
        print(" ERROR:", e)

# === WRITE CSVs ===
def write_csv(filename, rows):
    with open(filename, "w", newline="", encoding="utf-8") as f:
        writer = csv.writer(f, quoting=csv.QUOTE_ALL)
        writer.writerows(rows)

write_csv("movie.csv", [["Title", "ReleaseDate", "Genre", "MPAARating", "Poster", "Runtime"]] + [
    [m["Title"], m["ReleaseDate"], m["Genre"], m["MPAARating"], m["Poster"], m["Runtime"]] for m in movies
])

write_csv("person.csv", [["FirstName", "LastName", "DateOfBirth", "Minit"]] + [
    [k[0], k[1], k[2], ""] for k in people.keys()
])

write_csv("directs.csv", [["MovieTitle", "MovieReleaseDate", "FirstName", "LastName", "DateOfBirth"]] + directs)
write_csv("writes.csv", [["MovieTitle", "MovieReleaseDate", "FirstName", "LastName", "DateOfBirth"]] + writes)
write_csv("stars_in.csv", [["MovieTitle", "MovieReleaseDate", "FirstName", "LastName", "DateOfBirth"]] + stars_in)

# Dummy data for USER, REVIEW, etc.
write_csv("user.csv", [["Email", "PhoneNumber", "FirstName", "Minit", "LastName", "DateOfBirth", "ProfilePicture"]] + [
    [f"user{i}@example.com", f"555-000{i}", f"User{i}", "A", f"Last{i}", "1990-01-01", ""] for i in range(1, 11)
])
write_csv("review.csv", [["DatePosted", "Author", "WrittenReview", "Rating"]] + [
    [f"2025-01-01 12:00:0{i}", f"User{i}", "Great movie!", 8] for i in range(1, 6)
])
write_csv("user_review.csv", [["DatePosted", "UserEmail", "UserPhoneNumber"]] + [
    [f"2025-01-01 12:00:0{i}", f"user{i}@example.com", f"555-000{i}"] for i in range(1, 6)
])
write_csv("favorites.csv", [["UserEmail", "UserPhoneNumber", "MovieTitle", "MovieReleaseDate"]] + [
    [f"user{i}@example.com", f"555-000{i}", movies[i-1]["Title"], movies[i-1]["ReleaseDate"]] for i in range(1, 6)
])

print("\nAll CSVs generated!")