package main

import (
	"fmt"
	"sync"
	"crypto/sha1"
	"encoding/hex"
	"bufio"
	"os"
	"log"
)

var wg sync.WaitGroup

// var alphabet = []rune {'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9'}
var alphabet = []string {"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"}
var BATCH int = 100000
var VERBOSE = false

func hashpwd(pwd string) string {
	var pwdBytes []byte
	pwdBytes = append(pwdBytes, []byte(pwd)...)
	salt := []byte("supersecretsalt")
	for i := 0; i < 30; i++ {
		content := append(salt, pwdBytes[:]...)
		digest := sha1.Sum(content)
		pwdBytes = []byte(hex.EncodeToString(digest[:]))
	}
	
	return string(pwdBytes)
}

func idx2pwd(idx []int) string {
	s := ""
	for _, d := range idx {
		s = s + alphabet[d]
	}
	return s
}

func genpwd(ch chan<- string, dict string) {
	f, err := os.Open(dict)
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}
	defer f.Close()

	scanner := bufio.NewScanner(f)
	for scanner.Scan() {
		ch <- scanner.Text()
	}

	if err := scanner.Err(); err != nil {
		log.Fatal(err)
	}

	close(ch)
}

// func genpwd(sz int, ch chan<- string) {
// 	defer wg.Done()
// 	var pools [][]string
// 	for i := 0; i < sz; i++ {
// 		pools = append(pools, alphabet)
// 	}

// 	result := [][]string{{}}
// 	for _, pool := range pools {
// 		var newResult [][]string
// 		for _, y := range pool {
// 			for _, x:= range result {
// 				t := append(x, y)
// 				newResult = append(newResult, t)
// 			}
// 		}
// 		result = newResult
// 	}

// 	for _, prod := range result {
// 		s := ""
// 		for _, p := range prod {
// 			s += fmt.Sprintf("%v", p)
// 		}

// 		ch <- s
// 	}

// 	close(ch)
// }

func worker(target string, ch <-chan string, out chan<- bool, success chan<- bool) {
	defer wg.Done()

	count := 0
	for password := range ch {
		if hashpwd(password) == target {
			fmt.Printf("Found the password! %v\n", password)
			success <- true
			return
		}
		count ++
		if count % BATCH == 0 {
			out <- true
		}
	}
}

func counter(out <-chan bool) {
	count := 0
	for _ = range out {
		count ++
		if VERBOSE {
			fmt.Printf("%v\n", count * BATCH)
		}
	}
}

func test() {
	target := "00f909787ab4a4657ef4e6a46d7b291acfa2870c"

	h := hashpwd("roberto12345")
	if h != target {
		fmt.Printf("Wrong hash function, rewrite it! %v", h)
	} else {
		fmt.Printf("Correct hash function!")
	}
}

func main() {
	// hash := "00f909787ab4a4657ef4e6a46d7b291acfa2870c"

	if len(os.Args) != 3 {
		fmt.Printf("Usage: cracker <hash> <dictionary>\n")
		os.Exit(1)
	}

	hash := os.Args[1]
	dict := os.Args[2]
	
	ch := make(chan string, 100)
	out := make(chan bool, 10)
	success := make(chan bool)
	done := make(chan bool)

	go genpwd(ch, dict)

	go counter(out)

	go func() {
		for i := 0; i < 10; i++ {
			wg.Add(1)
			go worker(hash, ch, out, success)
		}
		wg.Wait()
		done <- true
	}()


	select {
	case <-success:
		fmt.Println("Success!")
	case <-done:
		fmt.Println("Finishes!")
	}
}
